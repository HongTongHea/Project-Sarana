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
            Log::info('Contact form submitted', $request->all());

            // Store the contact message in database
            $contact = Contact::create($request->all());
            Log::info('Contact saved to database', ['contact_id' => $contact->id]);

            // Prepare and send Telegram message
            $telegramMessage = $this->formatTelegramMessage($request);
            Log::info('Attempting to send Telegram message');
            
            $telegramSent = $this->sendToTelegram($telegramMessage);

            if ($telegramSent) {
                Log::info('Telegram message sent successfully');
                // Redirect to personal Telegram account - USING YOUR ACTUAL USERNAME
                return redirect('https://t.me/Tonghear')
                    ->with('success', 'Thank you for your message! Redirecting to our Telegram...');
            } else {
                Log::warning('Telegram message failed to send, but contact was saved');
                return redirect()->route('contact.create')
                    ->with('success', 'Thank you for your message! We have received your message and will get back to you soon.');
            }

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Sorry, there was an error sending your message. Please try again.')
                ->withInput();
        }
    }

    /**
     * Format message for Telegram
     */
    private function formatTelegramMessage(Request $request)
    {
        $message = "🆕 *NEW CONTACT FORM SUBMISSION*\n\n";
        $message .= "👤 *Name:* {$request->name}\n";
        $message .= "📧 *Email:* {$request->email}\n";
        $message .= "📞 *Phone:* " . ($request->phone_number ?: 'Not provided') . "\n";
        $message .= "💬 *Message:*\n{$request->message}\n\n";
        $message .= "⏰ *Submitted:* " . now()->format('M j, Y g:i A');
        $message .= "\n🌐 *From:* Angkor Tech Computer Website";

        return $message;
    }

    /**
     * Send message to Telegram
     */
    private function sendToTelegram($message)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        Log::info('Telegram Configuration Check', [
            'bot_token_length' => $botToken ? strlen($botToken) : 0,
            'chat_id' => $chatId,
            'has_bot_token' => !empty($botToken),
            'has_chat_id' => !empty($chatId)
        ]);

        // Check if credentials are set
        if (!$botToken || !$chatId) {
            Log::error('Telegram credentials missing from .env file');
            return false;
        }

        // Validate token format (should contain colon)
        if (strpos($botToken, ':') === false) {
            Log::error('Invalid Telegram token format - missing colon');
            return false;
        }

        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown'
        ];

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                'form_params' => $data,
                'timeout' => 10,
                'verify' => false,
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            Log::info('Telegram API Response', [
                'status_code' => $statusCode,
                'response' => $responseData
            ]);

            return $responseData['ok'] ?? false;

        } catch (\Exception $e) {
            Log::error('Telegram API connection error: ' . $e->getMessage());
            return false;
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
