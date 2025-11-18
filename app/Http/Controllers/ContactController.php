<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Contact::create($request->all());

            return redirect()->route('contact.create')
                ->with('success', 'Thank you for your message! We will get back to you soon.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Sorry, there was an error sending your message. Please try again.')
                ->withInput();
        }
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
