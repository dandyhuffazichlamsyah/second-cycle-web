<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'nullable|string|max:20',
            'subject'    => 'required|string|max:255',
            'department' => 'nullable|in:sales,service,support,finance',
            'message'    => 'required|string|min:10',
            'newsletter' => 'nullable|boolean',
        ]);

        // Save to database first
        $contactMessage = ContactMessage::create($validated);

        // Send email notification
        $this->sendEmailNotification($contactMessage);

        // Generate WhatsApp URL for auto-redirect
        $whatsappUrl = $this->generateWhatsAppUrl($contactMessage);

        return redirect()
            ->route('contact.show')
            ->with('success', 'Pesan kamu sudah terkirim, tim kami akan segera menghubungi Anda!')
            ->with('whatsapp_url', $whatsappUrl);
    }

    private function sendEmailNotification(ContactMessage $message)
    {
        try {
            // Send ALL messages to your email regardless of department
            $recipientEmail = 'dandyhuffaz52@gmail.com';
            
            // Send email to your email
            Mail::to($recipientEmail)
                ->send(new ContactMessageMail($message));

            // Also send WhatsApp notification
            $this->sendWhatsAppNotification($message);

            Log::info('Contact message email sent successfully', [
                'message_id' => $message->id,
                'department' => $message->department,
                'recipient' => $recipientEmail
            ]);

        } catch (\Exception $e) {
            // Log error but don't fail the request
            Log::error('Failed to send contact message email', [
                'message_id' => $message->id,
                'error' => $e->getMessage(),
                'department' => $message->department
            ]);

            // In development, you might want to know about this
            if (app()->environment('local')) {
                // You could flash a warning or just log it
                Log::warning('Email configuration may not be set up properly');
            }
        }
    }

    private function sendWhatsAppNotification(ContactMessage $message)
    {
        try {
            // Format WhatsApp message
            $whatsappMessage = $this->formatWhatsAppMessage($message);
            
            // Create WhatsApp URL
            $whatsappUrl = "https://wa.me/6281296986113?text=" . urlencode($whatsappMessage);
            
            // Log the WhatsApp URL (in production, you might use WhatsApp API)
            Log::info('WhatsApp notification URL generated', [
                'message_id' => $message->id,
                'whatsapp_url' => $whatsappUrl
            ]);

            // Note: This just logs the URL. For actual WhatsApp sending, 
            // you would need WhatsApp Business API integration
            // For now, you can manually click the logged URL or implement API later

        } catch (\Exception $e) {
            Log::error('Failed to generate WhatsApp notification', [
                'message_id' => $message->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function generateWhatsAppUrl(ContactMessage $message)
    {
        $whatsappMessage = $this->formatWhatsAppMessage($message);
        return "https://wa.me/6281296986113?text=" . urlencode($whatsappMessage);
    }

    private function formatWhatsAppMessage(ContactMessage $message)
    {
        $deptText = $message->department ? strtoupper($message->department) : 'UMUM';
        
        return "📧 *PESAN BARU DARI CUSTOMER SECONDCYCLE* 📧\n\n" .
               "👤 *Nama:* {$message->name}\n" .
               "📧 *Email:* {$message->email}\n" .
               ($message->phone ? "📱 *Telepon:* {$message->phone}\n" : "") .
               "🏢 *Departemen:* {$deptText}\n" .
               "📝 *Subjek:* {$message->subject}\n\n" .
               "💬 *Pesan:*\n{$message->message}\n\n" .
               "📅 *Waktu:* {$message->created_at->format('d M Y H:i')}\n\n" .
               "🔥 *Segera hubungi customer!*";
    }
}
