<?php
// app/Http/Controllers/Admin/ContactMessageController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Affiche la liste des messages
     */
// Modifier la méthode index
    public function index()
    {
        $messages = ContactMessage::query()
            ->when(request('unread'), fn($q) => $q->unread())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'unreadCount' => ContactMessage::unread()->count()
        ]);
}

    /**
     * Affiche un message spécifique
     */
    public function show(ContactMessage $message)
    {
        // Marquer comme lu
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Supprime un message
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message supprimé avec succès');
    }
}