<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Institution;
use App\Models\Lesson;
use App\Models\TeacherProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $locale = app()->getLocale();

        $featured_teachers = TeacherProfile::with(['user', 'institution', 'lessons'])
            ->where('status', 1)
            ->where('is_verified', true)
            ->orderByDesc('rating')
            ->take(8)
            ->get();

        $lessons = Lesson::where('status', 1)
            ->withCount('teachers')
            ->orderByDesc('teachers_count')
            ->take(12)
            ->get();

        $institutions = Institution::where('status', 1)
            ->withCount('teacherProfiles')
            ->orderByDesc('teacher_profiles_count')
            ->take(8)
            ->get();

        $latest_documents = Document::with(['teacherProfile.user', 'lesson'])
            ->where('status', 1)
            ->where('is_public', true)
            ->latest()
            ->take(6)
            ->get();

        $counts = [
            'teachers' => TeacherProfile::where('status', 1)->count(),
            'institutions' => Institution::where('status', 1)->count(),
            'documents' => Document::where('status', 1)->where('is_public', true)->count(),
            'lessons' => Lesson::where('status', 1)->count(),
        ];

        return view('front.home', compact('featured_teachers', 'lessons', 'institutions', 'latest_documents', 'counts', 'locale'));
    }

    public function setLocale(string $locale): RedirectResponse
    {
        if (in_array($locale, ['tk', 'ru', 'en'])) {
            session()->put('locale', $locale);
        }

        return back();
    }
}