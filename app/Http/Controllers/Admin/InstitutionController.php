<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InstitutionController extends Controller
{
    public function index(): View
    {
        $institutions = Institution::withCount(['departments', 'teacherProfiles'])->latest()->paginate(15);
        return view('admin.institutions.index', compact('institutions'));
    }

    public function create(): View
    {
        return view('admin.institutions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_tk' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'city' => 'nullable|string|max:100',
            'address_tk' => 'nullable|string',
            'address_ru' => 'nullable|string',
            'address_en' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('institutions', 'public');
        }

        $slug = Str::slug($request->name_en);
        if (Institution::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        Institution::create([
            'name_tk' => $request->name_tk,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $slug,
            'type' => $request->type,
            'city' => $request->city,
            'address_tk' => $request->address_tk,
            'address_ru' => $request->address_ru,
            'address_en' => $request->address_en,
            'phone' => $request->phone,
            'website' => $request->website,
            'logo' => $logoPath,
            'status' => $request->boolean('status', true) ? 1 : 0,
        ]);

        return redirect()->route('admin.institutions.index')->with('success', 'Institution created successfully.');
    }

    public function edit(Institution $institution): View
    {
        return view('admin.institutions.edit', compact('institution'));
    }

    public function update(Request $request, Institution $institution): RedirectResponse
    {
        $request->validate([
            'name_tk' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'city' => 'nullable|string|max:100',
            'address_tk' => 'nullable|string',
            'address_ru' => 'nullable|string',
            'address_en' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name_tk' => $request->name_tk,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'type' => $request->type,
            'city' => $request->city,
            'address_tk' => $request->address_tk,
            'address_ru' => $request->address_ru,
            'address_en' => $request->address_en,
            'phone' => $request->phone,
            'website' => $request->website,
            'status' => $request->boolean('status') ? 1 : 0,
        ];

        if ($request->hasFile('logo')) {
            if ($institution->logo) {
                Storage::disk('public')->delete($institution->logo);
            }
            $data['logo'] = $request->file('logo')->store('institutions', 'public');
        }

        $institution->update($data);

        return redirect()->route('admin.institutions.index')->with('success', 'Institution updated successfully.');
    }

    public function destroy(Institution $institution): RedirectResponse
    {
        if ($institution->logo) {
            Storage::disk('public')->delete($institution->logo);
        }
        $institution->delete();

        return redirect()->route('admin.institutions.index')->with('success', 'Institution deleted successfully.');
    }
}