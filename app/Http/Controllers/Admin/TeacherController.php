<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Institution;
use App\Models\Lesson;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(Request $request): View
    {
        $query = TeacherProfile::with(['user', 'institution', 'department', 'lessons']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('institution_id')) {
            $query->where('institution_id', $request->institution_id);
        }

        $teachers = $query->latest()->paginate(15);
        $institutions = Institution::where('status', 1)->get();

        return view('admin.teachers.index', compact('teachers', 'institutions'));
    }

    public function create(): View
    {
        $institutions = Institution::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();
        $lessons = Lesson::where('status', 1)->get();

        return view('admin.teachers.create', compact('institutions', 'departments', 'lessons'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'avatar' => 'nullable|image|max:2048',
            'institution_id' => 'nullable|exists:institutions,id',
            'department_id' => 'nullable|exists:departments,id',
            'title_tk' => 'nullable|string|max:255',
            'title_ru' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'degree_tk' => 'nullable|string|max:255',
            'degree_ru' => 'nullable|string|max:255',
            'degree_en' => 'nullable|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'bio_tk' => 'nullable|string',
            'bio_ru' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'education_center_tk' => 'nullable|string|max:255',
            'education_center_ru' => 'nullable|string|max:255',
            'education_center_en' => 'nullable|string|max:255',
            'lessons' => 'nullable|array',
            'lessons.*' => 'exists:lessons,id',
        ]);

        DB::transaction(function () use ($request) {
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'avatar' => $avatarPath,
                'role' => 'teacher',
                'status' => 1,
            ]);

            $profile = TeacherProfile::create([
                'user_id' => $user->id,
                'institution_id' => $request->institution_id,
                'department_id' => $request->department_id,
                'title_tk' => $request->title_tk,
                'title_ru' => $request->title_ru,
                'title_en' => $request->title_en,
                'degree_tk' => $request->degree_tk,
                'degree_ru' => $request->degree_ru,
                'degree_en' => $request->degree_en,
                'experience_years' => $request->experience_years,
                'bio_tk' => $request->bio_tk,
                'bio_ru' => $request->bio_ru,
                'bio_en' => $request->bio_en,
                'education_center_tk' => $request->education_center_tk,
                'education_center_ru' => $request->education_center_ru,
                'education_center_en' => $request->education_center_en,
                'is_verified' => $request->boolean('is_verified'),
                'status' => 1,
            ]);

            if ($request->has('lessons')) {
                $profile->lessons()->sync($request->lessons);
            }
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function edit(TeacherProfile $teacher): View
    {
        $teacher->load(['user', 'lessons']);
        $institutions = Institution::where('status', 1)->get();
        $departments = Department::where('institution_id', $teacher->institution_id)->get();
        $lessons = Lesson::where('status', 1)->get();

        return view('admin.teachers.edit', compact('teacher', 'institutions', 'departments', 'lessons'));
    }

    public function update(Request $request, TeacherProfile $teacher): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $teacher->user_id,
            'email' => 'nullable|email|unique:users,email,' . $teacher->user_id,
            'password' => 'nullable|string|min:6',
            'avatar' => 'nullable|image|max:2048',
            'institution_id' => 'nullable|exists:institutions,id',
            'department_id' => 'nullable|exists:departments,id',
            'title_tk' => 'nullable|string|max:255',
            'title_ru' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'degree_tk' => 'nullable|string|max:255',
            'degree_ru' => 'nullable|string|max:255',
            'degree_en' => 'nullable|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'bio_tk' => 'nullable|string',
            'bio_ru' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'education_center_tk' => 'nullable|string|max:255',
            'education_center_ru' => 'nullable|string|max:255',
            'education_center_en' => 'nullable|string|max:255',
            'lessons' => 'nullable|array',
            'lessons.*' => 'exists:lessons,id',
        ]);

        DB::transaction(function () use ($request, $teacher) {
            $userData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('avatar')) {
                if ($teacher->user->avatar) {
                    Storage::disk('public')->delete($teacher->user->avatar);
                }
                $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            $teacher->user->update($userData);

            $teacher->update([
                'institution_id' => $request->institution_id,
                'department_id' => $request->department_id,
                'title_tk' => $request->title_tk,
                'title_ru' => $request->title_ru,
                'title_en' => $request->title_en,
                'degree_tk' => $request->degree_tk,
                'degree_ru' => $request->degree_ru,
                'degree_en' => $request->degree_en,
                'experience_years' => $request->experience_years,
                'bio_tk' => $request->bio_tk,
                'bio_ru' => $request->bio_ru,
                'bio_en' => $request->bio_en,
                'education_center_tk' => $request->education_center_tk,
                'education_center_ru' => $request->education_center_ru,
                'education_center_en' => $request->education_center_en,
                'is_verified' => $request->boolean('is_verified'),
            ]);

            $teacher->lessons()->sync($request->lessons ?? []);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(TeacherProfile $teacher): RedirectResponse
    {
        DB::transaction(function () use ($teacher) {
            if ($teacher->user->avatar) {
                Storage::disk('public')->delete($teacher->user->avatar);
            }
            $teacher->user->delete();
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}