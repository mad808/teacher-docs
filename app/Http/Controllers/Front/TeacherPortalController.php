<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Document;
use App\Models\Institution;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeacherPortalController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $profile = $user->teacherProfile;

        abort_unless($profile, 403);

        $documents_count = $profile->documents()->count();
        $downloads_total = $profile->documents()->sum('downloads_count');
        $conversations_count = $user->conversationsAsTeacher()->count();

        $latest_documents = $profile->documents()->with('lesson')->latest()->take(5)->get();

        return view('front.teacher_portal.dashboard', compact('profile', 'documents_count', 'downloads_total', 'conversations_count', 'latest_documents'));
    }

    public function editProfile(): View
    {
        $user = Auth::user();
        $profile = $user->teacherProfile;

        abort_unless($profile, 403);

        $profile->load('lessons');
        $institutions = Institution::where('status', 1)->get();
        $departments = $profile->institution_id
            ? Department::where('institution_id', $profile->institution_id)->where('status', 1)->get()
            : collect();
        $lessons = Lesson::where('status', 1)->get();

        return view('front.teacher_portal.edit_profile', compact('profile', 'institutions', 'departments', 'lessons'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $profile = $user->teacherProfile;

        abort_unless($profile, 403);

        $request->validate([
            'name' => 'required|string|max:255',
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

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->update([
                'avatar' => $request->file('avatar')->store('avatars', 'public'),
            ]);
        }

        $user->update(['name' => $request->name]);

        $profile->update([
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
        ]);

        $profile->lessons()->sync($request->lessons ?? []);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function documents(): View
    {
        $profile = Auth::user()->teacherProfile;
        abort_unless($profile, 403);

        $documents = $profile->documents()->with('lesson')->latest()->paginate(15);
        $lessons = Lesson::where('status', 1)->get();

        return view('front.teacher_portal.documents', compact('documents', 'lessons'));
    }

    public function storeDocument(Request $request): RedirectResponse
    {
        $profile = Auth::user()->teacherProfile;
        abort_unless($profile, 403);

        $request->validate([
            'title_tk' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_tk' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'description_en' => 'nullable|string',
            'lesson_id' => 'nullable|exists:lessons,id',
            'file' => 'required|file|max:51200|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip',
            'is_public' => 'boolean',
        ]);

        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        Document::create([
            'teacher_profile_id' => $profile->id,
            'lesson_id' => $request->lesson_id,
            'title_tk' => $request->title_tk,
            'title_ru' => $request->title_ru,
            'title_en' => $request->title_en,
            'description_tk' => $request->description_tk,
            'description_ru' => $request->description_ru,
            'description_en' => $request->description_en,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_extension' => strtolower($file->getClientOriginalExtension()),
            'is_public' => $request->boolean('is_public', true),
            'status' => 1,
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    public function destroyDocument(Document $document): RedirectResponse
    {
        $profile = Auth::user()->teacherProfile;
        abort_unless($profile && $document->teacher_profile_id === $profile->id, 403);

        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }
}