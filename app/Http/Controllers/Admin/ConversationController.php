<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConversationController extends Controller
{
    public function index(): View
    {
        $conversations = Conversation::with(['teacher', 'student'])
            ->withCount('messages')
            ->latest('last_message_at')
            ->paginate(15);

        return view('admin.conversations.index', compact('conversations'));
    }

    public function show(Conversation $conversation): View
    {
        $conversation->load(['teacher', 'student', 'messages.sender']);
        return view('admin.conversations.show', compact('conversation'));
    }

    public function destroyMessage(Message $message): RedirectResponse
    {
        $message->delete();
        return back()->with('success', 'Message deleted successfully.');
    }

    public function destroy(Conversation $conversation): RedirectResponse
    {
        $conversation->delete();
        return redirect()->route('admin.conversations.index')->with('success', 'Conversation deleted successfully.');
    }
}