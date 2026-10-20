@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Resminama maglumaty',
            'ru' => 'Информация о материале',
            'en' => 'Document Details',
        ],
        'back' => [
            'tk' => 'Yza dolan',
            'ru' => 'Назад',
            'en' => 'Back',
        ],
        'titles_section' => [
            'tk' => 'Sözbaşylar',
            'ru' => 'Названия на разных языках',
            'en' => 'Titles in Languages',
        ],
        'descriptions_section' => [
            'tk' => 'Düşündirişler',
            'ru' => 'Описания',
            'en' => 'Descriptions',
        ],
        'file_details' => [
            'tk' => 'Faýl maglumaty',
            'ru' => 'Файловые данные',
            'en' => 'File Information',
        ],
        'teacher_details' => [
            'tk' => 'Mugallym barada',
            'ru' => 'Информация о преподавателе',
            'en' => 'Teacher Information',
        ],
        'lesson' => [
            'tk' => 'Ders',
            'ru' => 'Предмет',
            'en' => 'Subject',
        ],
        'file_name' => [
            'tk' => 'Faýlyň ady',
            'ru' => 'Имя файла',
            'en' => 'File Name',
        ],
        'file_size' => [
            'tk' => 'Göwrümi',
            'ru' => 'Размер',
            'en' => 'File Size',
        ],
        'downloads' => [
            'tk' => 'Ýüklenen sany',
            'ru' => 'Количество скачиваний',
            'en' => 'Downloads Count',
        ],
        'visibility' => [
            'tk' => 'Görnüşi',
            'ru' => 'Видимость',
            'en' => 'Visibility',
        ],
        'public' => [
            'tk' => 'Köpçülige açyk',
            'ru' => 'Публичный',
            'en' => 'Public',
        ],
        'private' => [
            'tk' => 'Gizlin / Çäkli',
            'ru' => 'Приватный',
            'en' => 'Private',
        ],
        'status' => [
            'tk' => 'Işjeňlik ýagdaýy',
            'ru' => 'Статус публикации',
            'en' => 'Publication Status',
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
        'download_file' => [
            'tk' => 'Faýly ýükläp al',
            'ru' => 'Скачать файл',
            'en' => 'Download File',
        ],
        'delete_btn' => [
            'tk' => 'Resminamany poz',
            'ru' => 'Удалить документ',
            'en' => 'Delete Document',
        ],
        'delete_confirm' => [
            'tk' => 'Bu resminamany doly pozmak isleýärsiňizmi?',
            'ru' => 'Удалить этот документ навсегда?',
            'en' => 'Are you sure you want to delete this document permanently?',
        ],
        'created_at' => [
            'tk' => 'Goşulan senesi',
            'ru' => 'Дата добавления',
            'en' => 'Created At',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])
@section('page_title', $texts['page_title'][$locale])

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0 text-dark">{{ $texts['page_title'][$locale] }}</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> {{ $texts['back'][$locale] }}
            </a>
            <a href="{{ route('admin.documents.download', $document->id) }}" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="bi bi-download me-1"></i> {{ $texts['download_file'][$locale] }}
            </a>
            <form action="{{ route('admin.documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('{{ $texts['delete_confirm'][$locale] }}')" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                    <i class="bi bi-trash3 me-1"></i> {{ $texts['delete_btn'][$locale] }}
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                    <i class="bi bi-translate text-primary me-2"></i>{{ $texts['titles_section'][$locale] }}
                </h6>

                <div class="mb-3">
                    <label class="form-label small text-muted mb-1">Türkmençe</label>
                    <div class="p-3 bg-light rounded-3 fw-semibold text-dark">{{ $document->title_tk }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted mb-1">Русский</label>
                    <div class="p-3 bg-light rounded-3 fw-semibold text-dark">{{ $document->title_ru }}</div>
                </div>

                <div class="mb-0">
                    <label class="form-label small text-muted mb-1">English</label>
                    <div class="p-3 bg-light rounded-3 fw-semibold text-dark">{{ $document->title_en }}</div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                    <i class="bi bi-file-text text-primary me-2"></i>{{ $texts['descriptions_section'][$locale] }}
                </h6>

                <div class="mb-3">
                    <label class="form-label small text-muted mb-1">Türkmençe</label>
                    <div class="p-3 bg-light rounded-3 small text-dark">
                        {{ $document->description_tk ?: '—' }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted mb-1">Русский</label>
                    <div class="p-3 bg-light rounded-3 small text-dark">
                        {{ $document->description_ru ?: '—' }}
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label small text-muted mb-1">English</label>
                    <div class="p-3 bg-light rounded-3 small text-dark">
                        {{ $document->description_en ?: '—' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                    <i class="bi bi-person-badge text-primary me-2"></i>{{ $texts['teacher_details'][$locale] }}
                </h6>

                @if($document->teacherProfile && $document->teacherProfile->user)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @if($document->teacherProfile->user->avatar)
                            <img src="{{ asset('storage/' . $document->teacherProfile->user->avatar) }}" class="rounded-circle object-fit-cover shadow-xs" width="50" height="50" alt="">
                        @else
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold fs-4" style="width: 50px; height: 50px;">
                                {{ strtoupper(substr($document->teacherProfile->user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ $document->teacherProfile->user->name }}</h6>
                            <small class="text-muted d-block">{{ $document->teacherProfile->user->phone }}</small>
                            <small class="text-muted d-block">{{ $document->teacherProfile->user->email }}</small>
                        </div>
                    </div>

                    <a href="{{ route('admin.teachers.edit', $document->teacher_profile_id) }}" class="btn btn-light btn-sm w-100 border rounded-pill">
                        <i class="bi bi-person me-1"></i> Mugallym profilini aç
                    </a>
                @else
                    <div class="text-muted small">—</div>
                @endif
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                    <i class="bi bi-file-earmark-check text-primary me-2"></i>{{ $texts['file_details'][$locale] }}
                </h6>

                <ul class="list-unstyled small d-flex flex-column gap-3 mb-4">
                    <li class="d-flex justify-content-between">
                        <span class="text-muted">{{ $texts['lesson'][$locale] }}:</span>
                        <span class="fw-semibold text-dark">{{ $document->lesson?->{'name_' . $locale} ?? '—' }}</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="text-muted">{{ $texts['file_name'][$locale] }}:</span>
                        <span class="fw-semibold text-dark text-break text-end" style="max-width: 180px;">{{ $document->file_name }}</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="text-muted">{{ $texts['file_size'][$locale] }}:</span>
                        <span class="fw-semibold text-dark">{{ round($document->file_size / 1024, 1) }} KB ({{ strtoupper($document->file_extension) }})</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="text-muted">{{ $texts['downloads'][$locale] }}:</span>
                        <span class="badge bg-light text-dark border rounded-pill px-2">{{ $document->downloads_count }}</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="text-muted">{{ $texts['visibility'][$locale] }}:</span>
                        @if($document->is_public)
                            <span class="badge bg-success bg-opacity-10 text-success">{{ $texts['public'][$locale] }}</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $texts['private'][$locale] }}</span>
                        @endif
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="text-muted">{{ $texts['status'][$locale] }}:</span>
                        @if($document->status === 1)
                            <span class="badge bg-success bg-opacity-10 text-success">{{ $texts['active'][$locale] }}</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning">{{ $texts['inactive'][$locale] }}</span>
                        @endif
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="text-muted">{{ $texts['created_at'][$locale] }}:</span>
                        <span class="text-dark">{{ $document->created_at->format('d.m.Y H:i') }}</span>
                    </li>
                </ul>

                <form action="{{ route('admin.documents.toggle-status', $document->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-outline-primary btn-sm w-100 rounded-pill">
                        <i class="bi bi-arrow-repeat me-1"></i> {{ $texts['toggle_status'][$locale] }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection