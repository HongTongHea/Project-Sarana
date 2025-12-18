<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Show the contact form
     */
    public function create()
    {
        return view('contactpage');
    }

   /**
     * Store a newly created contact message
     */

    public function store(Request $request)
    {
        // Debug: Log the incoming request
        Log::info('Contact form submission started', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'message' => 'required|string|min:10|max:1000',
        ], [
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'message.required' => 'Please enter your message',
            'message.min' => 'Message must be at least 10 characters long',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Log::info('Contact form validation passed', $request->all());

            // Store the contact message in database
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'message' => $request->message,
            ]);
            
            Log::info('Contact saved to database', ['contact_id' => $contact->id]);

            // Create Telegram deep link with pre-filled message in the input field
            $telegramMessage = $this->formatUserTelegramMessage($request);
            $telegramUrl = $this->createTelegramDeepLink($telegramMessage);
            
            Log::info('Redirecting to Telegram', ['url' => $telegramUrl]);

            // Always redirect to Telegram with the pre-filled message
            return redirect($telegramUrl)
                ->with('success', 'Thank you for your message! Redirecting to Telegram...');

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Sorry, there was an error sending your message. Please try again.')
                ->withInput();
        }
    }

    /**
     * Format message for user to send via Telegram
     */
    private function formatUserTelegramMessage(Request $request)
    {
        $message = "👋 Hello! I contacted you through your website.\n\n";
        $message .= "📋 Contact Details:\n";
        $message .= "👤 Name: {$request->name}\n";
        $message .= "✉️ Email: {$request->email}\n";
        $message .= "📞 Phone: " . ($request->phone_number ?: 'Not provided') . "\n\n";
        $message .= "💬 My Message:\n";
        $message .= "{$request->message}\n\n";
        $message .= "⏰ Sent:" . now()->format('M j, Y g:i A');

        return $message;
    }

    /**
     * Create Telegram deep link with pre-filled message in the input field
     */
    private function createTelegramDeepLink($message)
    {
        $username = 'Tonghear'; // Your Telegram username without @
        
        // URL encode the message
        $encodedMessage = urlencode($message);
        
        // Method 1: Using the "text" parameter (most reliable for pre-filling message input)
        $telegramUrl = "https://t.me/{$username}?text={$encodedMessage}";
        
        Log::info('Generated Telegram URL', [
            'username' => $username,
            'message_length' => strlen($message),
            'url' => $telegramUrl
        ]);
        
        return $telegramUrl;
    }

    /**
     * Alternative method using share URL (opens share dialog with pre-filled text)
     */
    private function createTelegramShareLink($message)
    {
        $encodedMessage = urlencode($message);
        return "https://t.me/share/url?url=&text={$encodedMessage}";
    }



    /**
     * Display a listing of contact messages (admin)
     */
    public function index()
    {
        $contacts = Contact::latest()->get();
        return view('contact.index', compact('contacts'));
    }

    /**
     * Display the specified contact message
     */
    public function show(Contact $contact)
    {
        // Mark as read when viewing
        $contact->update(['read_status' => true]);

        return view('contact.show', compact('contact'));
    }

    /**
     * Remove the specified contact message
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contact.index')
            ->with('success', 'Contact message deleted successfully.');
    }

    /**
     * Get unread contact messages count
     */
    public function unreadCount()
    {
        $count = Contact::where('read_status', false)->count();

        return response()->json([
            'unread_count' => $count
        ]);
    }

    /**
     * Mark a contact message as read
     */
    public function markAsRead(Contact $contact)
    {
        $contact->update(['read_status' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Message marked as read'
        ]);
    }
}
