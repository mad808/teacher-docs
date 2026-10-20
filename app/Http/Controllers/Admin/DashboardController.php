<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Document;
use App\Models\Institution;
use App\Models\Lesson;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'teachers_count' => User::where('role', 'teacher')->count(),
            'students_count' => User::where('role', 'student')->count(),
            'institutions_count' => Institution::count(),
            'lessons_count' => Lesson::count(),
            'documents_count' => Document::count(),
            'conversations_count' => Conversation::count(),
        ];

        $latest_teachers = TeacherProfile::with(['user', 'institution', 'department'])
            ->latest()
            ->take(5)
            ->get();

        $latest_documents = Document::with(['teacherProfile.user', 'lesson'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latest_teachers', 'latest_documents'));
    }
}