<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.index', [
            'messages' => ContactMessage::latest()->paginate(12),
        ]);
    }

    public function markRead(Request $request, ContactMessage $message)
    {
        $message->update(['status' => 'read', 'read_at' => now()]);

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => "Tandai pesan sebagai read: {$message->email}",
            'auditable_type' => ContactMessage::class,
            'auditable_id' => $message->id,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'Pesan ditandai read.');
    }

    public function destroy(Request $request, ContactMessage $message)
    {
        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => "Hapus pesan: {$message->email}",
            'auditable_type' => ContactMessage::class,
            'auditable_id' => $message->id,
            'ip_address' => $request->ip(),
        ]);

        $message->delete();

        return back()->with('status', 'Pesan berhasil dihapus.');
    }
}
