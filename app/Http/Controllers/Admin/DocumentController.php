<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Document::with(['teacherProfile.user', 'lesson']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_tk', 'ilike', "%{$search}%")
                  ->orWhere('title_ru', 'ilike', "%{$search}%")
                  ->orWhere('title_en', 'ilike', "%{$search}%");
            });
        }

        $documents = $query->latest()->paginate(15);
        return view('admin.documents.index', compact('documents'));
    }

    public function show(Document $document): View
    {
        $document->load(['teacherProfile.user', 'lesson']);
        return view('admin.documents.show', compact('document'));
    }

    public function download(Document $document): BinaryFileResponse
    {
        return response()->download(storage_path('app/public/' . $document->file_path), $document->file_name);
    }

    public function toggleStatus(Document $document): RedirectResponse
    {
        $document->update([
            'status' => $document->status === 1 ? 0 : 1,
        ]);

        return back()->with('success', 'Document status updated.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Document deleted successfully.');
    }
}