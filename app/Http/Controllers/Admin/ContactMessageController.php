<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;

class ContactMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display all contact messages
     */
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        // Filter by department
        if ($request->department) {
            $query->where('department', $request->department);
        }

        // Filter by read status
        if ($request->has('read') && $request->read !== '') {
            $query->where('read', $request->read);
        }

        // Search by name or email
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        $messages = $query->paginate(20);
        $departments = ['sales', 'service', 'support', 'finance'];
        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::where('read', false)->count(),
            'today' => ContactMessage::whereDate('created_at', today())->count(),
        ];

        return view('admin.contacts.index', compact('messages', 'departments', 'stats'));
    }

    /**
     * Show single contact message
     */
    public function show(ContactMessage $message)
    {
        // Mark as read
        if (!$message->read) {
            $message->update(['read' => true]);
        }

        return view('admin.contacts.show', compact('message'));
    }

    /**
     * Reply to contact message
     */
    public function reply(Request $request, ContactMessage $message)
    {
        $request->validate([
            'reply' => 'required|string|min:10',
            'subject' => 'required|string|max:255',
        ]);

        try {
            // Send email reply
            Mail::to($message->email)->send(new ContactReplyMail($message, $request->reply, $request->subject));

            // Mark message as replied
            $message->update([
                'read' => true,
                'replied_at' => now(),
                'reply_content' => $request->reply,
            ]);

            return redirect()->back()
                ->with('success', 'Balasan email berhasil dikirim ke ' . $message->email);

        } catch (\Exception $e) {
            \Log::error('Failed to send reply email: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }

    /**
     * Mark message as read/unread
     */
    public function toggleRead(ContactMessage $message)
    {
        $message->update(['read' => !$message->read]);
        
        $status = $message->read ? 'dibaca' : 'belum dibaca';
        
        return redirect()->back()
            ->with('success', 'Pesan ditandai sebagai ' . $status);
    }

    /**
     * Delete contact message
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        
        return redirect()->route('admin.contacts')
            ->with('success', 'Pesan berhasil dihapus');
    }

    /**
     * Export contact messages to CSV
     */
    public function export(Request $request)
    {
        $messages = ContactMessage::latest();

        // Apply same filters as index
        if ($request->department) {
            $messages->where('department', $request->department);
        }
        if ($request->has('read') && $request->read !== '') {
            $messages->where('read', $request->read);
        }

        $messages = $messages->get();

        $filename = 'contact_messages_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($messages) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'ID', 'Nama', 'Email', 'Telepon', 'Departemen', 
                'Subjek', 'Pesan', 'Newsletter', 'Status', 'Tanggal'
            ]);

            // CSV Data
            foreach ($messages as $message) {
                fputcsv($file, [
                    $message->id,
                    $message->name,
                    $message->email,
                    $message->phone ?? '-',
                    $message->department ?? 'Umum',
                    $message->subject,
                    $message->message,
                    $message->newsletter ? 'Ya' : 'Tidak',
                    $message->read ? 'Dibaca' : 'Belum Dibaca',
                    $message->created_at->format('d M Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get unread contact count for AJAX
     */
    public function getUnreadCount()
    {
        try {
            $count = ContactMessage::where('read', false)->count();
            
            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get unread count'
            ], 500);
        }
    }
}
