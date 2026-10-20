<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\TeacherProfile;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $conversations = Conversation::with(['teacher', 'student', 'messages' => fn($q) => $q->latest()->take(1)])
            ->where('teacher_id', $userId)
            ->orWhere('student_id', $userId)
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('front.chat.index', compact('conversations'));
    }

    public function start(TeacherProfile $teacher): RedirectResponse
    {
        $studentId = Auth::id();
        $teacherUserId = $teacher->user_id;

        if ($studentId === $teacherUserId) {
            return back()->with('error', 'You cannot start a chat with yourself.');
        }

        $conversation = Conversation::firstOrCreate(
            [
                'teacher_id' => $teacherUserId,
                'student_id' => $studentId,
            ],
            [
                'last_message_at' => Carbon::now(),
            ]
        );

        return redirect()->route('chat.show', $conversation->id);
    }

    public function show(Conversation $conversation): View
    {
        $userId = Auth::id();

        abort_unless($conversation->teacher_id === $userId || $conversation->student_id === $userId, 403);

        $conversation->load(['teacher', 'student', 'messages.sender']);

        $conversation->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => Carbon::now()]);

        return view('front.chat.show', compact('conversation'));
    }

    public function sendMessage(Request $request, Conversation $conversation): RedirectResponse
    {
        $userId = Auth::id();

        abort_unless($conversation->teacher_id === $userId || $conversation->student_id === $userId, 403);

        $request->validate([
            'message' => 'required|string|max:2000',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,zip',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('chat_attachments', 'public');
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'message' => $request->message,
            'attachment_path' => $attachmentPath,
        ]);

        $conversation->update([
            'last_message_at' => Carbon::now(),
        ]);

        return back();
    }
}