<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Institution;
use App\Models\Lesson;
use App\Models\TeacherProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();

        $query = TeacherProfile::with(['user', 'institution', 'department', 'lessons'])
            ->where('status', 1);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search, $locale) {
                $q->whereHas('user', function ($sub) use ($search) {
                    $sub->where('name', 'ilike', "%{$search}%");
                })
                ->orWhere("bio_{$locale}", 'ilike', "%{$search}%")
                ->orWhere("title_{$locale}", 'ilike', "%{$search}%")
                ->orWhere("education_center_{$locale}", 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('institution_id')) {
            $query->where('institution_id', $request->institution_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('lesson_id')) {
            $query->whereHas('lessons', function ($q) use ($request) {
                $q->where('lessons.id', $request->lesson_id);
            });
        }

        if ($request->filled('experience')) {
            $query->where('experience_years', '>=', $request->experience);
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'rating' => $query->orderByDesc('rating'),
                'experience' => $query->orderByDesc('experience_years'),
                default => $query->latest(),
            };
        } else {
            $query->latest();
        }

        $teachers = $query->paginate(12)->withQueryString();
        $institutions = Institution::where('status', 1)->get();
        $departments = $request->filled('institution_id')
            ? Department::where('institution_id', $request->institution_id)->where('status', 1)->get()
            : collect();
        $lessons = Lesson::where('status', 1)->get();

        return view('front.teachers.index', compact('teachers', 'institutions', 'departments', 'lessons', 'locale'));
    }

    public function show(TeacherProfile $teacher): View
    {
        abort_if($teacher->status !== 1, 404);

        $locale = app()->getLocale();

        $teacher->load([
            'user',
            'institution',
            'department',
            'lessons',
            'documents' => function ($q) {
                $q->where('status', 1)->where('is_public', true)->latest();
            },
        ]);

        $similar_teachers = TeacherProfile::with(['user', 'institution'])
            ->where('status', 1)
            ->where('id', '!=', $teacher->id)
            ->where(function ($q) use ($teacher) {
                $q->where('institution_id', $teacher->institution_id)
                  ->orWhereHas('lessons', function ($sub) use ($teacher) {
                      $sub->whereIn('lessons.id', $teacher->lessons->pluck('id'));
                  });
            })
            ->take(4)
            ->get();

        return view('front.teachers.show', compact('teacher', 'similar_teachers', 'locale'));
    }
}