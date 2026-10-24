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
        'qr_card_title' => [
            'tk' => 'Sanly QR Wizitka',
            'ru' => 'Цифровая QR Визитка',
            'en' => 'Digital QR Business Card',
        ],
        'qr_card_desc' => [
            'tk' => 'Profili paýlaşmak ýa-da telefonyňyzda açmak üçin skanirläň.',
            'ru' => 'Отсканируйте камерой телефона, чтобы открыть профиль.',
            'en' => 'Scan with phone camera to view or share this profile.',
        ],
        'copy_link' => [
            'tk' => 'Salgy göçür',
            'ru' => 'Копировать ссылку',
            'en' => 'Copy Link',
        ],
        'copied' => [
            'tk' => 'Göçürildi!',
            'ru' => 'Скопировано!',
            'en' => 'Copied!',
        ],
        'download_qr' => [
            'tk' => 'QR Kody ýükle',
            'ru' => 'Скачать QR',
            'en' => 'Download QR',
        ],
        'share_profile' => [
            'tk' => 'Paýlaşmak',
            'ru' => 'Поделиться',
            'en' => 'Share Profile',
        ],
    ];

    $profileUrl = url()->current();
    $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=350x350&margin=10&color=15803d&data=" . urlencode($profileUrl);
@endphp

@section('title', $teacher->user->name . ' - ' . ($teacher->{'title_' . $locale} ?? 'ProTeachers'))

@section('content')
<div class="bg-light border-bottom py-4 py-md-5">
    <div class="container">
        <!-- Hero Header -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <div class="row align-items-center g-4">
                <!-- Avatar -->
                <div class="col-12 col-md-auto text-center">
                    <div class="position-relative d-inline-block">
                        @if($teacher->user->avatar)
                            <img src="{{ asset('storage/' . $teacher->user->avatar) }}" 
                                 class="rounded-circle object-fit-cover border border-4 border-white shadow" 
                                 width="120" height="120" 
                                 alt="{{ $teacher->user->name }}">
                        @else
                            <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center fw-bold fs-1 border border-4 border-white shadow" 
                                 style="width: 120px; height: 120px;">
                                {{ strtoupper(substr($teacher->user->name, 0, 1)) }}
                            </div>
                        @endif

                        @if($teacher->is_verified)
                            <span class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-1 d-flex align-items-center justify-content-center border border-white shadow" 
                                  style="width: 32px; height: 32px; font-size: 1rem;" 
                                  title="{{ $texts['verified_title'][$locale] }}">
                                <i class="bi bi-patch-check-fill"></i>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="col-12 col-md text-center text-md-start">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 mb-2">
                        <h2 class="fw-bold text-dark mb-0 fs-3 fs-md-2">{{ $teacher->user->name }}</h2>
                        @if($teacher->is_verified)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 fw-semibold small">
                                <i class="bi bi-patch-check-fill me-1"></i>{{ $texts['verified_title'][$locale] }}
                            </span>
                        @endif
                    </div>

                    <p class="text-secondary mb-2 fs-6">
                        <span class="fw-bold text-dark">{{ $teacher->{'title_' . $locale} ?: 'Mugallym' }}</span>
                        @if($teacher->{'degree_' . $locale})
                            &bull; <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $teacher->{'degree_' . $locale} }}</span>
                        @endif
                    </p>

                    @if($teacher->institution)
                        <div class="text-muted small mb-3">
                            <i class="bi bi-building text-success me-1"></i>
                            <span class="fw-semibold">{{ $teacher->institution->{'name_' . $locale} }}</span>
                            @if($teacher->department)
                                &bull; {{ $teacher->department->{'name_' . $locale} }}
                            @endif
                        </div>
                    @endif

                    <!-- Stat Chips -->
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 pt-1">
                        <div class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-medium">
                            <i class="bi bi-clock-history text-secondary me-1"></i>
                            <strong>{{ $teacher->experience_years }}</strong> ýyl tejribe
                        </div>
                        <div class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-medium">
                            <i class="bi bi-file-earmark-text text-primary me-1"></i>
                            <strong>{{ $teacher->documents->count() }}</strong> material
                        </div>
                        <div class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-3 py-2 rounded-pill fw-medium">
                            <i class="bi bi-star-fill text-warning me-1"></i>
                            <strong>{{ number_format($teacher->rating, 1) }}</strong>
                            <span class="text-muted small">({{ $teacher->reviews_count }})</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="col-12 col-md-auto text-center text-md-end d-flex flex-column flex-sm-row flex-md-column gap-2 justify-content-center">
                    @auth
                        @if(auth()->id() !== $teacher->user_id)
                            <a href="{{ route('chat.start', $teacher->id) }}" class="btn btn-success btn-lg rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                <i class="bi bi-chat-dots-fill me-1"></i> {{ $texts['send_message'][$locale] }}
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success btn-lg rounded-pill px-4 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-chat-dots me-1"></i> {{ $texts['send_message'][$locale] }}
                        </a>
                    @endauth

                    <a href="#qr-section" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-medium small">
                        <i class="bi bi-qr-code-scan me-1"></i> QR Wizitka
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-4 py-md-5">
    <div class="row g-4">
        <!-- Main Content Column -->
        <div class="col-lg-8">
            <!-- Biography -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center">
                    <i class="bi bi-person-lines-fill text-success me-2 fs-4"></i>
                    {{ $texts['about'][$locale] }}
                </h5>
                <div class="text-secondary lh-lg" style="font-size: 1.05rem;">
                    {!! nl2br(e($teacher->{'bio_' . $locale} ?: 'Maglumat goşulmadyk.')) !!}
                </div>
            </div>

            <!-- Subjects -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center">
                    <i class="bi bi-journal-bookmark-fill text-success me-2 fs-4"></i>
                    {{ $texts['subjects'][$locale] }}
                </h5>
                <div class="d-flex flex-wrap gap-2">
                    @forelse($teacher->lessons as $lesson)
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-semibold fs-6 shadow-xs">
                            <i class="bi {{ $lesson->icon ?: 'bi-book' }} text-success me-1"></i>
                            {{ $lesson->{'name_' . $locale} }}
                        </span>
                    @empty
                        <span class="text-muted small">—</span>
                    @endforelse
                </div>
            </div>

            <!-- Materials / Documents -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                        <i class="bi bi-folder2-open text-success me-2 fs-4"></i>
                        {{ $texts['materials'][$locale] }}
                    </h5>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-semibold">
                        {{ $teacher->documents->count() }} Faýl
                    </span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($teacher->documents as $doc)
                        <div class="p-3 rounded-4 border bg-light d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 hover-shadow transition">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-white p-2 text-success border shadow-xs d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-file-earmark-pdf fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">{{ $doc->{'title_' . $locale} }}</h6>
                                    <div class="d-flex align-items-center gap-2 small text-muted">
                                        <span class="badge bg-white text-secondary border text-uppercase">{{ $doc->file_extension ?? 'PDF' }}</span>
                                        <span>&bull;</span>
                                        <span>{{ round($doc->file_size / 1024, 1) }} KB</span>
                                        <span>&bull;</span>
                                        <span><i class="bi bi-download me-1 text-success"></i>{{ $doc->downloads_count }}</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('documents.download', $doc->id) }}" class="btn btn-outline-success btn-sm rounded-pill px-4 py-2 flex-shrink-0 fw-semibold">
                                <i class="bi bi-download me-1"></i> {{ $texts['download'][$locale] }}
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            {{ $texts['no_materials'][$locale] }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <!-- BIG CENTERED QR CODE CARD -->
            <div id="qr-section" class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4 text-center">
                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                    <span class="badge bg-success bg-opacity-10 text-success p-2 rounded-circle">
                        <i class="bi bi-qr-code fs-5"></i>
                    </span>
                    <h6 class="fw-bold text-dark mb-0">{{ $texts['qr_card_title'][$locale] }}</h6>
                </div>
                <p class="text-muted small mb-3">
                    {{ $texts['qr_card_desc'][$locale] }}
                </p>

                <!-- Bigger Centered QR Container with border frame -->
                <div class="p-3 bg-light rounded-4 border d-inline-block mx-auto mb-3 shadow-inner">
                    <img id="teacher-qr-code" 
                         src="{{ $qrApiUrl }}" 
                         alt="QR Code" 
                         class="img-fluid rounded-3 bg-white p-2 border shadow-sm"
                         style="max-width: 230px; width: 100%; height: auto; display: block; margin: 0 auto;">
                </div>

                <!-- Teacher Name on Badge -->
                <div class="small fw-bold text-dark mb-3">
                    {{ $teacher->user->name }}
                </div>

                <!-- Actions: Copy Link & Download QR -->
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-success rounded-pill py-2 fw-semibold shadow-xs" onclick="copyProfileLink(this)">
                        <i class="bi bi-link-45deg fs-5 align-middle me-1"></i> 
                        <span id="copy-btn-text">{{ $texts['copy_link'][$locale] }}</span>
                    </button>

                    <a href="{{ $qrApiUrl }}" download="{{ Str::slug($teacher->user->name) }}-qr-code.png" class="btn btn-outline-secondary rounded-pill py-2 fw-semibold small">
                        <i class="bi bi-download me-1"></i> {{ $texts['download_qr'][$locale] }}
                    </a>
                </div>

                <!-- Social Share Icons -->
                <div class="d-flex align-items-center justify-content-center gap-2 mt-3 pt-3 border-top">
                    <span class="small text-muted me-1">{{ $texts['share_profile'][$locale] }}:</span>
                    <a href="https://t.me/share/url?url={{ urlencode($profileUrl) }}&text={{ urlencode($teacher->user->name . ' - ProTeachers') }}" 
                       target="_blank" 
                       class="btn btn-light btn-sm rounded-circle border text-primary" 
                       title="Telegram" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="bi bi-telegram fs-6"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($teacher->user->name . ' ' . $profileUrl) }}" 
                       target="_blank" 
                       class="btn btn-light btn-sm rounded-circle border text-success" 
                       title="WhatsApp" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="bi bi-whatsapp fs-6"></i>
                    </a>
                </div>
            </div>

            <!-- Academic Info -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h6 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center">
                    <i class="bi bi-mortarboard-fill text-success me-2 fs-5"></i>
                    {{ $texts['academic_info'][$locale] }}
                </h6>

                <ul class="list-unstyled small d-flex flex-column gap-3 mb-0">
                    <li class="d-flex justify-content-between align-items-start gap-2">
                        <span class="text-muted">{{ $texts['institution'][$locale] }}:</span>
                        <span class="fw-semibold text-dark text-end">
                            {{ $teacher->institution?->{'name_' . $locale} ?? '—' }}
                        </span>
                    </li>
                    <li class="d-flex justify-content-between align-items-start gap-2">
                        <span class="text-muted">{{ $texts['department'][$locale] }}:</span>
                        <span class="fw-semibold text-dark text-end">
                            {{ $teacher->department?->{'name_' . $locale} ?? '—' }}
                        </span>
                    </li>
                    <li class="d-flex justify-content-between align-items-start gap-2">
                        <span class="text-muted">{{ $texts['degree'][$locale] }}:</span>
                        <span class="fw-semibold text-dark text-end">
                            {{ $teacher->{'degree_' . $locale} ?: '—' }}
                        </span>
                    </li>
                    <li class="d-flex justify-content-between align-items-start gap-2">
                        <span class="text-muted">{{ $texts['center'][$locale] }}:</span>
                        <span class="fw-semibold text-dark text-end">
                            {{ $teacher->{'education_center_' . $locale} ?: '—' }}
                        </span>
                    </li>
                    <li class="d-flex justify-content-between align-items-start gap-2">
                        <span class="text-muted">{{ $texts['experience'][$locale] }}:</span>
                        <span class="fw-bold text-success text-end">{{ $teacher->experience_years }} ýyl</span>
                    </li>
                </ul>
            </div>

            <!-- Similar Teachers -->
            @if(isset($similar_teachers) && $similar_teachers->count() > 0)
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center">
                        <i class="bi bi-people-fill text-success me-2 fs-5"></i>
                        {{ $texts['similar'][$locale] }}
                    </h6>

                    <div class="d-flex flex-column gap-3">
                        @foreach($similar_teachers as $sTeacher)
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div class="d-flex align-items-center gap-2 min-w-0">
                                    @if($sTeacher->user->avatar)
                                        <img src="{{ asset('storage/' . $sTeacher->user->avatar) }}" class="rounded-circle object-fit-cover border" width="42" height="42" alt="">
                                    @else
                                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center fw-bold small" style="width: 42px; height: 42px;">
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

                                <a href="{{ route('teachers.show', $sTeacher->id) }}" class="btn btn-light btn-sm rounded-circle border p-1" title="Gör" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
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

<script>
function copyProfileLink(btn) {
    const url = "{{ $profileUrl }}";
    const textSpan = document.getElementById('copy-btn-text');
    const originalText = textSpan.innerText;

    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(() => {
            textSpan.innerText = "{{ $texts['copied'][$locale] }}";
            btn.classList.replace('btn-success', 'btn-dark');
            setTimeout(() => {
                textSpan.innerText = originalText;
                btn.classList.replace('btn-dark', 'btn-success');
            }, 2500);
        });
    } else {
        const dummy = document.createElement('input');
        document.body.appendChild(dummy);
        dummy.value = url;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        textSpan.innerText = "{{ $texts['copied'][$locale] }}";
        btn.classList.replace('btn-success', 'btn-dark');
        setTimeout(() => {
            textSpan.innerText = originalText;
            btn.classList.replace('btn-dark', 'btn-success');
        }, 2500);
    }
}
</script>
@endsection