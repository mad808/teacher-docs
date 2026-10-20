@extends('front.layouts.app')

@php
    $texts = [
        'verified_title' => [
            'tk' => 'Tassyklanan hünärmen',
            'ru' => 'Проверенный специалист',
            'en' => 'Verified Educator',
        ],
        'send_message' => [
            'tk' => 'Göni hat ýazmak',
            'ru' => 'Написать сообщение',
            'en' => 'Send Direct Message',
        ],
        'about' => [
            'tk' => 'Mugallym barada / Biografiýa',
            'ru' => 'О преподавателе / Биография',
            'en' => 'About Teacher / Biography',
        ],
        'academic_info' => [
            'tk' => 'Ylmy maglumatlar',
            'ru' => 'Академические данные',
            'en' => 'Academic Information',
        ],
        'subjects' => [
            'tk' => 'Okadýan dersleri',
            'ru' => 'Преподаваемые дисциплины',
            'en' => 'Taught Subjects',
        ],
        'materials' => [
            'tk' => 'Ýüklenen okuw materiallary',
            'ru' => 'Опубликованные материалы',
            'en' => 'Educational Materials',
        ],
        'institution' => [
            'tk' => 'Okuw jaýy',
            'ru' => 'Учебное заведение',
            'en' => 'Institution',
        ],
        'department' => [
            'tk' => 'Kafedra',
            'ru' => 'Кафедра',
            'en' => 'Department',
        ],
        'degree' => [
            'tk' => 'Ylmy derejesi',
            'ru' => 'Ученая степень',
            'en' => 'Academic Degree',
        ],
        'center' => [
            'tk' => 'Ylmy / Bilim merkezi',
            'ru' => 'Научный / Учебный центр',
            'en' => 'Education Center',
        ],
        'experience' => [
            'tk' => 'Iş tejribesi',
            'ru' => 'Опыт преподавания',
            'en' => 'Teaching Experience',
        ],
        'download' => [
            'tk' => 'Ýükläp al',
            'ru' => 'Скачать',
            'en' => 'Download',
        ],
        'no_materials' => [
            'tk' => 'Bu mugallym entek açyk okuw resminamasy ýüklemändir.',
            'ru' => 'Преподаватель пока не загрузил учебные материалы.',
            'en' => 'No public documents uploaded by this educator yet.',
        ],
        'similar' => [
            'tk' => 'Meňzeş hünärmenler',
            'ru' => 'Похожие преподаватели',
            'en' => 'Similar Educators',
        ],
    ];
@endphp

@section('title', $teacher->user->name . ' - ' . ($teacher->{'title_' . $locale} ?? 'ProTeachers'))

@section('content')
<div class="bg-white border-bottom py-4 py-md-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-md-auto text-center text-md-start">
                <div class="position-relative d-inline-block">
                    @if($teacher->user->avatar)
                        <img src="{{ asset('storage/' . $teacher->user->avatar) }}" class="rounded-circle object-fit-cover border shadow" width="110" height="110" alt="{{ $teacher->user->name }}">
                    @else
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center fw-bold fs-1 border" style="width: 110px; height: 110px;">
                            {{ strtoupper(substr($teacher->user->name, 0, 1)) }}
                        </div>
                    @endif
                    @if($teacher->is_verified)
                        <span class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-1 d-flex align-items-center justify-content-center border border-white shadow-sm" style="width: 28px; height: 28px; font-size: 0.85rem;" title="{{ $texts['verified_title'][$locale] }}">
                            <i class="bi bi-patch-check-fill"></i>
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-md text-center text-md-start">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 mb-2">
                    <h3 class="fw-bold text-dark mb-0">{{ $teacher->user->name }}</h3>
                    @if($teacher->is_verified)
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-semibold">
                            <i class="bi bi-patch-check-fill me-1"></i>{{ $texts['verified_title'][$locale] }}
                        </span>
                    @endif
                </div>

                <p class="text-muted mb-2 fs-6">
                    {{ $teacher->{'title_' . $locale} ?: 'Mugallym' }}
                    @if($teacher->{'degree_' . $locale})
                        &bull; <span class="fw-semibold text-secondary">{{ $teacher->{'degree_' . $locale} }}</span>
                    @endif
                </p>

                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-3 small text-muted">
                    @if($teacher->institution)
                        <div><i class="bi bi-building text-primary me-1"></i>{{ $teacher->institution->{'name_' . $locale} }}</div>
                    @endif
                    <div><i class="bi bi-clock-history text-secondary me-1"></i>{{ $teacher->experience_years }} ýyl tejribe</div>
                    <div class="d-flex align-items-center gap-1 text-warning">
                        <i class="bi bi-star-fill"></i>
                        <span class="text-dark fw-bold">{{ number_format($teacher->rating, 1) }}</span>
                        <span class="text-muted">({{ $teacher->reviews_count }})</span>
                    </div>
                </div>
            </div>

            <div class="col-md-auto text-center text-md-end">
                @auth
                    @if(auth()->id() !== $teacher->user_id)
                        <a href="{{ route('chat.start', $teacher->id) }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-chat-dots-fill me-1"></i> {{ $texts['send_message'][$locale] }}
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                        <i class="bi bi-chat-dots me-1"></i> {{ $texts['send_message'][$locale] }}
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<div class="container py-4 py-md-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">
                    <i class="bi bi-person-lines-fill text-primary me-2"></i>{{ $texts['about'][$locale] }}
                </h5>
                <div class="text-secondary lh-lg">
                    {!! nl2br(e($teacher->{'bio_' . $locale} ?: 'Maglumat goşulmadyk.')) !!}
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">
                    <i class="bi bi-journal-bookmark text-primary me-2"></i>{{ $texts['subjects'][$locale] }}
                </h5>
                <div class="d-flex flex-wrap gap-2">
                    @forelse($teacher->lessons as $lesson)
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-semibold fs-6">
                            <i class="bi {{ $lesson->icon ?: 'bi-book' }} text-primary me-1"></i>
                            {{ $lesson->{'name_' . $locale} }}
                        </span>
                    @empty
                        <span class="text-muted small">—</span>
                    @endforelse
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="bi bi-folder2-open text-primary me-2"></i>{{ $texts['materials'][$locale] }}
                    </h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">
                        {{ $teacher->documents->count() }} Faýl
                    </span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($teacher->documents as $doc)
                        <div class="p-3 rounded-4 border bg-light d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-white p-2 text-primary border shadow-xs d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                    <i class="bi bi-file-earmark-arrow-down fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">{{ $doc->{'title_' . $locale} }}</h6>
                                    <div class="d-flex align-items-center gap-2 small text-muted">
                                        <span class="text-uppercase fw-semibold">{{ $doc->file_extension }}</span>
                                        <span>&bull;</span>
                                        <span>{{ round($doc->file_size / 1024, 1) }} KB</span>
                                        <span>&bull;</span>
                                        <span><i class="bi bi-download me-1"></i>{{ $doc->downloads_count }}</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('documents.download', $doc->id) }}" class="btn btn-primary btn-sm rounded-pill px-4 flex-shrink-0 fw-semibold">
                                <i class="bi bi-download me-1"></i> {{ $texts['download'][$locale] }}
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            {{ $texts['no_materials'][$locale] }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                    <i class="bi bi-mortarboard-fill text-primary me-2"></i>{{ $texts['academic_info'][$locale] }}
                </h6>

                <ul class="list-unstyled small d-flex flex-column gap-3 mb-0">
                    <li class="d-flex justify-content-between align-items-start">
                        <span class="text-muted">{{ $texts['institution'][$locale] }}:</span>
                        <span class="fw-semibold text-dark text-end" style="max-width: 60%;">
                            {{ $teacher->institution?->{'name_' . $locale} ?? '—' }}
                        </span>
                    </li>
                    <li class="d-flex justify-content-between align-items-start">
                        <span class="text-muted">{{ $texts['department'][$locale] }}:</span>
                        <span class="fw-semibold text-dark text-end" style="max-width: 60%;">
                            {{ $teacher->department?->{'name_' . $locale} ?? '—' }}
                        </span>
                    </li>
                    <li class="d-flex justify-content-between align-items-start">
                        <span class="text-muted">{{ $texts['degree'][$locale] }}:</span>
                        <span class="fw-semibold text-dark text-end" style="max-width: 60%;">
                            {{ $teacher->{'degree_' . $locale} ?: '—' }}
                        </span>
                    </li>
                    <li class="d-flex justify-content-between align-items-start">
                        <span class="text-muted">{{ $texts['center'][$locale] }}:</span>
                        <span class="fw-semibold text-dark text-end" style="max-width: 60%;">
                            {{ $teacher->{'education_center_' . $locale} ?: '—' }}
                        </span>
                    </li>
                    <li class="d-flex justify-content-between align-items-start">
                        <span class="text-muted">{{ $texts['experience'][$locale] }}:</span>
                        <span class="fw-bold text-dark text-end">{{ $teacher->experience_years }} ýyl</span>
                    </li>
                </ul>
            </div>

            @if($similar_teachers->count() > 0)
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-people-fill text-primary me-2"></i>{{ $texts['similar'][$locale] }}
                    </h6>

                    <div class="d-flex flex-column gap-3">
                        @foreach($similar_teachers as $sTeacher)
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div class="d-flex align-items-center gap-2 min-w-0">
                                    @if($sTeacher->user->avatar)
                                        <img src="{{ asset('storage/' . $sTeacher->user->avatar) }}" class="rounded-circle object-fit-cover border" width="38" height="38" alt="">
                                    @else
                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold small" style="width: 38px; height: 38px;">
                                            {{ strtoupper(substr($sTeacher->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <a href="{{ route('teachers.show', $sTeacher->id) }}" class="fw-semibold text-dark text-decoration-none small d-block text-truncate">
                                            {{ $sTeacher->user->name }}
                                        </a>
                                        <small class="text-muted d-block text-truncate" style="font-size: 0.72rem;">
                                            {{ $sTeacher->institution?->{'name_' . $locale} }}
                                        </small>
                                    </div>
                                </div>

                                <a href="{{ route('teachers.show', $sTeacher->id) }}" class="btn btn-light btn-sm rounded-circle border p-1" title="Gör">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection