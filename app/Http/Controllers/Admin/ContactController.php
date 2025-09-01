<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactReplyMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pages.contacts', compact('contacts'));
    }

    public function markAsRead($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['is_read' => true]);

        // AJAX request ise JSON döndür
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Mesaj okundu olarak işaretlendi.'
            ]);
        }

        return redirect()->back()->with('success', 'Mesaj okundu olarak işaretlendi.');
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|min:10'
        ]);

        $contact = Contact::findOrFail($id);
        // Emin olmak için
        if ($contact instanceof \Illuminate\Database\Eloquent\Collection) {
            $contact = $contact->first();
        }
        $contact->update([
            'reply' => $request->reply,
            'is_read' => true
        ]);

        // Cevabı e-posta olarak gönder
        Mail::to($contact->email)
            ->queue(new ContactReplyMail($contact));

        // AJAX request ise JSON döndür
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Mesaj cevaplandı ve e-posta gönderildi.'
            ]);
        }

        return redirect()->back()->with('success', 'Mesaj cevaplandı ve e-posta gönderildi.');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->forceDelete();

        // AJAX request ise JSON döndür
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Mesaj başarıyla silindi.'
            ]);
        }

        return redirect()->back()->with('success', 'Mesaj silindi.');
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }
}