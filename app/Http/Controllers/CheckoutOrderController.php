<?php

namespace App\Http\Controllers;

use App\Models\OnlineOrder;
use App\Models\OnlineOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CheckoutOrderController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to proceed with checkout.');
        }

        $user = Auth::user();
        return view('checkout', compact('user'));
    }

    /**
     * Process online order
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $validator = Validator::make($request->all(), [
            'customer_first_name' => 'required|string|max:255',
            'customer_last_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string|min:10',
            'billing_address' => 'required|string|min:10',
            'customer_notes' => 'nullable|string',
            'cart_items' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'shipping_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0.01',
        ], [
            'shipping_address.min' => 'Please provide a complete shipping address',
            'billing_address.min' => 'Please provide a complete billing address',
            'total_amount.min' => 'Total amount must be greater than zero',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();

            // Decode cart items
            $cart = json_decode($request->cart_items, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($cart)) {
                throw new \Exception('Invalid cart data format');
            }

            // Create online order with customer details
            $onlineOrder = OnlineOrder::create([
                'user_id' => $user->id,
                'customer_first_name' => $request->customer_first_name,
                'customer_last_name' => $request->customer_last_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone ?? '',
                'subtotal' => $request->subtotal,
                'discount_amount' => $request->discount_amount,
                'shipping_amount' => $request->shipping_amount,
                'total_amount' => $request->total_amount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address,
                'customer_notes' => $request->customer_notes,
            ]);

            // Add order items from cart
            foreach ($cart as $item) {
                $discountedPrice = isset($item['discount']) && $item['discount'] > 0 ?
                    $item['price'] * (1 - $item['discount'] / 100) :
                    $item['price'];

                OnlineOrderItem::create([
                    'online_order_id' => $onlineOrder->id,
                    'item_type' => 'App\Models\Product',
                    'item_id' => $item['id'] ?? 0,
                    'item_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'discount_percentage' => $item['discount'] ?? 0,
                    'discounted_price' => $discountedPrice,
                    'total_price' => $discountedPrice * $item['quantity'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $onlineOrder->id,
                'redirect_url' => route('order.confirmation', ['order' => $onlineOrder->id]),
                'message' => 'Order placed successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order placement failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to place order. Please try again.'
            ], 500);
        }
    }

    /**
     * Show order confirmation page
     */
    public function confirmation(OnlineOrder $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $order->load('items');
        return view('order-confirmation', compact('order'));
    }

    /**
     * ADMIN: Get all online orders (System View)
     */
    public function index()
    {
        $onlineOrders = OnlineOrder::with(['user', 'items']) // Make sure 'items' is included
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('online-orders.index', compact('onlineOrders'));
    }

    /**
     * CUSTOMER: Get customer's orders (Website View)
     */
    public function myOrders()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = OnlineOrder::where('user_id', Auth::id())
            ->withCount('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('website.my-orders', compact('orders'));
    }

    /**
     * ADMIN: Show specific online order (System View)
     */
    public function show(OnlineOrder $onlineOrder)
    {
        $onlineOrder->load(['user', 'items']);
        return view('online-orders.show', compact('onlineOrder'));
    }

    /**
     * CUSTOMER: Show specific order for customer (Website View)
     */
    public function myOrderShow(OnlineOrder $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $order->load('items');
        return view('website.my-order-detail', compact('order'));
    }

    public function updatePayment(Request $request, OnlineOrder $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        // Update payment
        $order->payment_status = $request->payment_status;

        // Auto update order status when paid
        if ($request->payment_status === 'paid') {
            $order->status = 'processing'; // or 'completed'
        }

        // If payment failed
        if ($request->payment_status === 'failed') {
            $order->status = 'pending';
        }

        $order->save();

        return redirect()->back()->with('success', 'Payment updated successfully');
    }


    public function destroy(OnlineOrder $order)
    {
        // Only allow deletion if order is pending
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be deleted.');
        }

        $order->items()->delete();
        $order->delete();

        return redirect()->route('online-orders.index')
            ->with('success', 'Online order deleted successfully.');
    }
}
