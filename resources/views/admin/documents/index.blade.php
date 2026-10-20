@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Ýüklenen resminamalar we okuw materiallary',
            'ru' => 'Учебные материалы и документы',
            'en' => 'Uploaded Documents & Materials',
        ],
        'search_placeholder' => [
            'tk' => 'Resminamanyň ady boýunça gözleg...',
            'ru' => 'Поиск по названию материала...',
            'en' => 'Search by document title...',
        ],
        'search_btn' => [
            'tk' => 'Gözle',
            'ru' => 'Поиск',
            'en' => 'Search',
        ],
        'title' => [
            'tk' => 'Sözbaşy',
            'ru' => 'Название',
            'en' => 'Title',
        ],
        'teacher' => [
            'tk' => 'Mugallym',
            'ru' => 'Преподаватель',
            'en' => 'Teacher',
        ],
        'lesson' => [
            'tk' => 'Ders',
            'ru' => 'Предмет',
            'en' => 'Subject',
        ],
        'file' => [
            'tk' => 'Faýl / Göwrüm',
            'ru' => 'Файл / Размер',
            'en' => 'File / Size',
        ],
        'downloads' => [
            'tk' => 'Ýüklemeler',
            'ru' => 'Скачиваний',
            'en' => 'Downloads',
        ],
        'status' => [
            'tk' => 'Ýagdaýy',
            'ru' => 'Статус',
            'en' => 'Status',
        ],
        'actions' => [
            'tk' => 'Hereketler',
            'ru' => 'Действия',
            'en' => 'Actions',
        ],
        'active' => [
            'tk' => 'Işjeň',
            'ru' => 'Активен',
            'en' => 'Active',
        ],
        'inactive' => [
            'tk' => 'Işjeň däl',
            'ru' => 'Неактивен',
            'en' => 'Inactive',
        ],
        'toggle_status' => [
            'tk' => 'Ýagdaýy üýtget',
            'ru' => 'Переключить статус',
            'en' => 'Toggle Status',
        ],
        'view' => [
            'tk' => 'Giňişleýin',
            'ru' => 'Подробнее',
            'en' => 'View Details',
        ],
        'download' => [
            'tk' => 'Ýükläp al',
            'ru' => 'Скачать',
            'en' => 'Download',
        ],
        'delete' => [
            'tk' => 'Poz',
            'ru' => 'Удалить',
            'en' => 'Delete',
        ],
        'delete_confirm' => [
            'tk' => 'Bu resminamany we faýly doly pozmak isleýärsiňizmi?',
            'ru' => 'Удалить этот материал и файл навсегда?',
            'en' => 'Are you sure you want to permanently delete this document and file?',
        ],
        'empty' => [
            'tk' => 'Hiç hili resminama tapylmady.',
            'ru' => 'Материалы не найдены.',
            'en' => 'No documents found.',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])
@section('page_title', $texts['page_title'][$locale])

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">{{ $texts['page_title'][$locale] }}</h4>
            <p class="text-muted small mb-0">{{ $documents->total() }} {{ strtolower($texts['page_title'][$locale]) }}</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.documents.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="{{ $texts['search_placeholder'][$locale] }}" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3">
                        {{ $texts['search_btn'][$locale] }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">{{ $texts['title'][$locale] }}</th>
                        <th>{{ $texts['teacher'][$locale] }}</th>
                        <th>{{ $texts['lesson'][$locale] }}</th>
                        <th>{{ $texts['file'][$locale] }}</th>
                        <th class="text-center">{{ $texts['downloads'][$locale] }}</th>
                        <th>{{ $texts['status'][$locale] }}</th>
                        <th class="text-end pe-4">{{ $texts['actions'][$locale] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                        <tr>
                            <td class="ps-4">
                                <a href="{{ route('admin.documents.show', $doc->id) }}" class="fw-bold text-dark text-decoration-none d-block">
                                    {{ $doc->{'title_' . $locale} }}
                                </a>
                                <small class="text-muted text-truncate d-block" style="max-width: 260px;">
                                    {{ $doc->file_name }}
                                </small>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($doc->teacherProfile?->user?->avatar)
                                        <img src="{{ asset('storage/' . $doc->teacherProfile->user->avatar) }}" class="rounded-circle object-fit-cover shadow-xs" width="34" height="34" alt="">
                                    @else
                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px; font-size: 0.8rem;">
                                            {{ strtoupper(substr($doc->teacherProfile?->user?->name ?? 'T', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="small fw-semibold text-dark">{{ $doc->teacherProfile?->user?->name ?? '—' }}</div>
                                        <small class="text-muted" style="font-size: 0.7rem;">{{ $doc->teacherProfile?->user?->phone }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if($doc->lesson)
                                    <span class="badge bg-light text-dark border">
                                        {{ $doc->lesson->{'name_' . $locale} }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary text-uppercase fw-bold">
                                    {{ $doc->file_extension }}
                                </span>
                                <small class="text-muted ms-1">{{ round($doc->file_size / 1024, 1) }} KB</small>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1">
                                    <i class="bi bi-download me-1 text-primary"></i>{{ $doc->downloads_count }}
                                </span>
                            </td>

                            <td>
                                <form action="{{ route('admin.documents.toggle-status', $doc->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm p-0 border-0" title="{{ $texts['toggle_status'][$locale] }}">
                                        @if($doc->status === 1)
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">
                                                <i class="bi bi-check-circle me-1"></i>{{ $texts['active'][$locale] }}
                                            </span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">
                                                <i class="bi bi-pause-circle me-1"></i>{{ $texts['inactive'][$locale] }}
                                            </span>
                                        @endif
                                    </button>
                                </form>
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.documents.download', $doc->id) }}" class="btn btn-sm btn-light border text-primary rounded-pill px-2" title="{{ $texts['download'][$locale] }}">
                                        <i class="bi bi-download"></i>
                                    </a>

                                    <a href="{{ route('admin.documents.show', $doc->id) }}" class="btn btn-sm btn-light border rounded-pill px-2" title="{{ $texts['view'][$locale] }}">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('{{ $texts['delete_confirm'][$locale] }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="{{ $texts['delete'][$locale] }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-file-earmark-x fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                {{ $texts['empty'][$locale] }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($documents->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $documents->links() }}
            </div>
        @endif
    </div>
</div>
@endsection