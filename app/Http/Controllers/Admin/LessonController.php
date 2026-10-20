<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function index(): View
    {
        $lessons = Lesson::withCount(['teachers', 'documents'])->latest()->paginate(15);
        return view('admin.lessons.index', compact('lessons'));
    }

    public function create(): View
    {
        return view('admin.lessons.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_tk' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $slug = Str::slug($request->name_en);
        if (Lesson::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        Lesson::create([
            'name_tk' => $request->name_tk,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $slug,
            'icon' => $request->icon,
            'status' => $request->boolean('status', true) ? 1 : 0,
        ]);

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson created successfully.');
    }

    public function edit(Lesson $lesson): View
    {
        return view('admin.lessons.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson): RedirectResponse
    {
        $request->validate([
            'name_tk' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $lesson->update([
            'name_tk' => $request->name_tk,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'icon' => $request->icon,
            'status' => $request->boolean('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Lesson $lesson): RedirectResponse
    {
        $lesson->delete();
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson deleted successfully.');
    }
}