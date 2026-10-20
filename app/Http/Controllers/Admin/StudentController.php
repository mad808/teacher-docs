<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'student');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $students = $query->latest()->paginate(15);

        return view('admin.students.index', compact('students'));
    }

    public function create(): View
    {
        return view('admin.students.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatarPath,
            'role' => 'student',
            'status' => 1,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    public function edit(User $student): View
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $student->id,
            'email' => 'nullable|email|unique:users,email,' . $student->id,
            'password' => 'nullable|string|min:6',
            'avatar' => 'nullable|image|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($student->avatar) {
                Storage::disk('public')->delete($student->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student): RedirectResponse
    {
        if ($student->avatar) {
            Storage::disk('public')->delete($student->avatar);
        }
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}