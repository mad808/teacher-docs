@extends('front.layouts.app')

@php
    $texts = [
        'page_title' => [
            'tk' => 'Okuw materiallary we elektron resminamalar',
            'ru' => 'Учебные материалы и электронные документы',
            'en' => 'Educational Materials & Documents',
        ],
        'page_desc' => [
            'tk' => 'Ýokary okuw jaýlarynyň mugallymlarynyň taýýarlan leksiýalaryny, gollanmalaryny we amaly işlerini göçürip alyň.',
            'ru' => 'Скачивайте лекции, авторские пособия и методические разработки преподавателей вузов.',
            'en' => 'Download lectures, study guides, and educational materials prepared by verified educators.',
        ],
        'search_placeholder' => [
            'tk' => 'Resminamanyň ady ýa-da mazmuny boýunça gözleg...',
            'ru' => 'Поиск по названию или описанию материала...',
            'en' => 'Search by document title or content...',
        ],
        'search_btn' => [
            'tk' => 'Gözle',
            'ru' => 'Поиск',
            'en' => 'Search',
        ],
        'all_lessons' => [
            'tk' => 'Ähli dersler',
            'ru' => 'Все предметы',
            'en' => 'All Subjects',
        ],
        'all_formats' => [
            'tk' => 'Ähli faýl görnüşleri',
            'ru' => 'Все форматы файлов',
            'en' => 'All File Formats',
        ],
        'filter_btn' => [
            'tk' => 'Süzgüç',
            'ru' => 'Фильтр',
            'en' => 'Filter',
        ],
        'reset_btn' => [
            'tk' => 'Arassala',
            'ru' => 'Сбросить',
            'en' => 'Reset',
        ],
        'download_btn' => [
            'tk' => 'Ýükläp al',
            'ru' => 'Скачать',
            'en' => 'Download',
        ],
        'downloads' => [
            'tk' => 'gezek ýüklenen',
            'ru' => 'скачиваний',
            'en' => 'downloads',
        ],
        'author' => [
            'tk' => 'Mugallym',
            'ru' => 'Преподаватель',
            'en' => 'Teacher',
        ],
        'empty' => [
            'tk' => 'Gözlegiňize laýyk gelýän hiç hili resminama tapylmady.',
            'ru' => 'Материалы по вашему запросу не найдены.',
            'en' => 'No documents found matching your criteria.',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])

@section('content')
<section class="bg-white border-bottom py-4 py-md-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold mb-3">
                    <i class="bi bi-folder2-open me-1"></i> {{ $documents->total() }} Resminama
                </span>
                <h2 class="fw-bold text-dark mb-2">{{ $texts['page_title'][$locale] }}</h2>
                <p class="text-muted small mb-0">{{ $texts['page_desc'][$locale] }}</p>
            </div>
        </div>
    </div>
</section>

<div class="container py-4 py-md-5">
    <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white mb-4">
        <form action="{{ route('documents.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="q" class="form-control bg-light border-start-0" placeholder="{{ $texts['search_placeholder'][$locale] }}" value="{{ request('q') }}">
                </div>
            </div>

            <div class="col-md-3">
                <select name="lesson_id" class="form-select select2">
                    <option value="">{{ $texts['all_lessons'][$locale] }}</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>
                            {{ $lesson->{'name_' . $locale} }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="file_extension" class="form-select">
                    <option value="">{{ $texts['all_formats'][$locale] }}</option>
                    <option value="pdf" {{ request('file_extension') == 'pdf' ? 'selected' : '' }}>PDF</option>
                    <option value="docx" {{ request('file_extension') == 'docx' ? 'selected' : '' }}>Word (DOCX)</option>
                    <option value="pptx" {{ request('file_extension') == 'pptx' ? 'selected' : '' }}>PowerPoint (PPTX)</option>
                    <option value="xlsx" {{ request('file_extension') == 'xlsx' ? 'selected' : '' }}>Excel (XLSX)</option>
                    <option value="zip" {{ request('file_extension') == 'zip' ? 'selected' : '' }}>ZIP / Arhiw</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-3 flex-grow-1 fw-semibold">
                    <i class="bi bi-funnel-fill me-1"></i> {{ $texts['filter_btn'][$locale] }}
                </button>
                @if(request()->anyFilled(['q', 'lesson_id', 'file_extension']))
                    <a href="{{ route('documents.index') }}" class="btn btn-light border rounded-3" title="{{ $texts['reset_btn'][$locale] }}">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="row g-4">
        @forelse($documents as $doc)
            @php
                $ext = strtolower($doc->file_extension);
                $badgeBg = match ($ext) {
                    'pdf' => 'bg-danger',
                    'doc', 'docx' => 'bg-primary',
                    'ppt', 'pptx' => 'bg-warning text-dark',
                    'xls', 'xlsx' => 'bg-success',
                    'zip', 'rar' => 'bg-secondary',
                    default => 'bg-dark',
                };
                $icon = match ($ext) {
                    'pdf' => 'bi-file-earmark-pdf-fill',
                    'doc', 'docx' => 'bi-file-earmark-word-fill',
                    'ppt', 'pptx' => 'bi-file-earmark-easel-fill',
                    'xls', 'xlsx' => 'bi-file-earmark-excel-fill',
                    'zip', 'rar' => 'bi-file-earmark-zip-fill',
                    default => 'bi-file-earmark-arrow-down-fill',
                };
            @endphp
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-column justify-content-between hover-shadow transition">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge {{ $badgeBg }} px-2 py-1 text-uppercase fw-bold" style="font-size: 0.7rem;">
                                <i class="bi {{ $icon }} me-1"></i>{{ $ext }}
                            </span>
                            <small class="text-muted fw-semibold" style="font-size: 0.75rem;">
                                {{ round($doc->file_size / 1024, 1) }} KB
                            </small>
                        </div>

                        <h6 class="fw-bold text-dark mb-2 text-truncate-2" style="min-height: 2.8rem; line-height: 1.4;">
                            {{ $doc->{'title_' . $locale} }}
                        </h6>

                        @if($doc->{'description_' . $locale})
                            <p class="text-muted small mb-3 text-truncate-2" style="font-size: 0.8rem; min-height: 2.4rem;">
                                {{ $doc->{'description_' . $locale} }}
                            </p>
                        @endif

                        @if($doc->lesson)
                            <div class="mb-3">
                                <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.72rem;">
                                    <i class="bi bi-tag-fill me-1 text-primary"></i>{{ $doc->lesson->{'name_' . $locale} }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="pt-3 border-top">
                        @if($doc->teacherProfile && $doc->teacherProfile->user)
                            <div class="d-flex align-items-center gap-2 mb-3">
                                @if($doc->teacherProfile->user->avatar)
                                    <img src="{{ asset('storage/' . $doc->teacherProfile->user->avatar) }}" class="rounded-circle object-fit-cover border" width="28" height="28" alt="">
                                @else
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; font-size: 0.75rem;">
                                        {{ strtoupper(substr($doc->teacherProfile->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <a href="{{ route('teachers.show', $doc->teacherProfile->id) }}" class="text-decoration-none text-dark fw-semibold small text-truncate d-block">
                                        {{ $doc->teacherProfile->user->name }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-download me-1 text-primary"></i>{{ $doc->downloads_count }} {{ $texts['downloads'][$locale] }}
                            </small>
                            <a href="{{ route('documents.download', $doc->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold">
                                <i class="bi bi-download me-1"></i> {{ $texts['download_btn'][$locale] }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5 text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                    <i class="bi bi-folder-x text-muted fs-1"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">{{ $texts['empty'][$locale] }}</h5>
                <a href="{{ route('documents.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 mt-2">
                    {{ $texts['reset_btn'][$locale] }}
                </a>
            </div>
        @endforelse
    </div>

    @if($documents->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $documents->links() }}
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .transition {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection