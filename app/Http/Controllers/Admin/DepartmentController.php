<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Department::with('institution')->withCount('teacherProfiles');

        if ($request->filled('institution_id')) {
            $query->where('institution_id', $request->institution_id);
        }

        $departments = $query->latest()->paginate(15);
        $institutions = Institution::where('status', 1)->get();

        return view('admin.departments.index', compact('departments', 'institutions'));
    }

    public function create(): View
    {
        $institutions = Institution::where('status', 1)->get();
        return view('admin.departments.create', compact('institutions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'institution_id' => 'required|exists:institutions,id',
            'name_tk' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->name_en);
        if (Department::where('institution_id', $request->institution_id)->where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        Department::create([
            'institution_id' => $request->institution_id,
            'name_tk' => $request->name_tk,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $slug,
            'status' => $request->boolean('status', true) ? 1 : 0,
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(Department $department): View
    {
        $institutions = Institution::where('status', 1)->get();
        return view('admin.departments.edit', compact('department', 'institutions'));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $request->validate([
            'institution_id' => 'required|exists:institutions,id',
            'name_tk' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $department->update([
            'institution_id' => $request->institution_id,
            'name_tk' => $request->name_tk,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'status' => $request->boolean('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
}