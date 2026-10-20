<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();

        $query = Document::with(['teacherProfile.user', 'lesson'])
            ->where('status', 1)
            ->where('is_public', true);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search, $locale) {
                $q->where("title_{$locale}", 'ilike', "%{$search}%")
                  ->orWhere("description_{$locale}", 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }

        if ($request->filled('file_extension')) {
            $query->where('file_extension', strtolower($request->file_extension));
        }

        $documents = $query->latest()->paginate(16)->withQueryString();
        $lessons = Lesson::where('status', 1)->get();

        return view('front.documents.index', compact('documents', 'lessons', 'locale'));
    }

    public function download(Document $document): BinaryFileResponse
    {
        abort_if($document->status !== 1 || !$document->is_public, 404);

        $document->increment('downloads_count');

        $path = storage_path('app/public/' . $document->file_path);
        abort_unless(file_exists($path), 404);

        return response()->download($path, $document->file_name);
    }
}