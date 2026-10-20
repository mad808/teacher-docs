@extends('front.layouts.app')

@php
    $texts = [
        'page_title' => [
            'tk' => 'Ýokary okuw mekdepleriniň mugallymlary',
            'ru' => 'Преподаватели учебных заведений',
            'en' => 'Educators & University Professors',
        ],
        'page_desc' => [
            'tk' => 'Ýurdumyzyň ýokary okuw jaýlarynyň we bilim merkezleriniň mugallymlaryny gözläň, baha beriň we göni habarlaşyň.',
            'ru' => 'Каталог преподавателей вузов и центров: находите нужного специалиста, читайте отзывы и пишите в чат.',
            'en' => 'Explore directory of verified university educators, read profiles, and contact them directly.',
        ],
        'search_placeholder' => [
            'tk' => 'Mugallymyň ady, kafedrasy ýa-da ylmy ugry...',
            'ru' => 'Поиск по имени, кафедре или направлению...',
            'en' => 'Search by teacher name, department, or field...',
        ],
        'institution_select' => [
            'tk' => 'Ähli okuw jaýlary',
            'ru' => 'Все учебные заведения',
            'en' => 'All Institutions',
        ],
        'lesson_select' => [
            'tk' => 'Ähli dersler',
            'ru' => 'Все предметы',
            'en' => 'All Subjects',
        ],
        'sort_by' => [
            'tk' => 'Tertiplemek',
            'ru' => 'Сортировка',
            'en' => 'Sort By',
        ],
        'sort_latest' => [
            'tk' => 'Täzeler',
            'ru' => 'Новые',
            'en' => 'Newest',
        ],
        'sort_rating' => [
            'tk' => 'Ýokary reýting',
            'ru' => 'Высокий рейтинг',
            'en' => 'Highest Rating',
        ],
        'sort_experience' => [
            'tk' => 'Köp tejribeli',
            'ru' => 'Большой опыт',
            'en' => 'Most Experienced',
        ],
        'filter_btn' => [
            'tk' => 'Gözle',
            'ru' => 'Применить',
            'en' => 'Apply',
        ],
        'reset_btn' => [
            'tk' => 'Arassala',
            'ru' => 'Сбросить',
            'en' => 'Reset',
        ],
        'exp_years' => [
            'tk' => 'ýyl tejribe',
            'ru' => 'лет стажа',
            'en' => 'yrs experience',
        ],
        'verified' => [
            'tk' => 'Tassyklanan',
            'ru' => 'Подтвержден',
            'en' => 'Verified',
        ],
        'view_profile' => [
            'tk' => 'Profilini gör',
            'ru' => 'Профиль',
            'en' => 'Profile',
        ],
        'send_message' => [
            'tk' => 'Hat ýazmak',
            'ru' => 'Написать',
            'en' => 'Message',
        ],
        'empty' => [
            'tk' => 'Gözlegiňize laýyk gelýän mugallym tapylmady.',
            'ru' => 'Преподаватели по вашему запросу не найдены.',
            'en' => 'No teachers found matching your criteria.',
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
                    <i class="bi bi-mortarboard me-1"></i> {{ $teachers->total() }} Mugallym
                </span>
                <h2 class="fw-bold text-dark mb-2">{{ $texts['page_title'][$locale] }}</h2>
                <p class="text-muted small mb-0">{{ $texts['page_desc'][$locale] }}</p>
            </div>
        </div>
    </div>
</section>

<div class="container py-4 py-md-5">
    <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white mb-4">
        <form action="{{ route('teachers.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="q" class="form-control bg-light border-start-0" placeholder="{{ $texts['search_placeholder'][$locale] }}" value="{{ request('q') }}">
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <select name="institution_id" class="form-select select2">
                    <option value="">{{ $texts['institution_select'][$locale] }}</option>
                    @foreach($institutions as $inst)
                        <option value="{{ $inst->id }}" {{ request('institution_id') == $inst->id ? 'selected' : '' }}>
                            {{ $inst->{'name_' . $locale} }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-2 col-md-4">
                <select name="lesson_id" class="form-select select2">
                    <option value="">{{ $texts['lesson_select'][$locale] }}</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>
                            {{ $lesson->{'name_' . $locale} }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-2 col-md-4">
                <select name="sort" class="form-select">
                    <option value="">{{ $texts['sort_latest'][$locale] }}</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>{{ $texts['sort_rating'][$locale] }}</option>
                    <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>{{ $texts['sort_experience'][$locale] }}</option>
                </select>
            </div>

            <div class="col-lg-1 col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-3 flex-grow-1 fw-semibold">
                    <i class="bi bi-funnel-fill"></i>
                </button>
                @if(request()->anyFilled(['q', 'institution_id', 'lesson_id', 'sort', 'experience']))
                    <a href="{{ route('teachers.index') }}" class="btn btn-light border rounded-3" title="{{ $texts['reset_btn'][$locale] }}">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="row g-4">
        @forelse($teachers as $teacher)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-column justify-content-between hover-shadow transition">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="position-relative flex-shrink-0">
                                @if($teacher->user->avatar)
                                    <img src="{{ asset('storage/' . $teacher->user->avatar) }}" class="rounded-circle object-fit-cover border shadow-xs" width="60" height="60" alt="{{ $teacher->user->name }}">
                                @else
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold fs-4" style="width: 60px; height: 60px;">
                                        {{ strtoupper(substr($teacher->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                @if($teacher->is_verified)
                                    <span class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-1 d-flex align-items-center justify-content-center border border-white" style="width: 20px; height: 20px; font-size: 0.65rem;" title="{{ $texts['verified'][$locale] }}">
                                        <i class="bi bi-check-lg"></i>
                                    </span>
                                @endif
                            </div>

                            <div class="flex-grow-1 min-w-0">
                                <h6 class="fw-bold text-dark mb-0 text-truncate">
                                    <a href="{{ route('teachers.show', $teacher->id) }}" class="text-dark text-decoration-none">
                                        {{ $teacher->user->name }}
                                    </a>
                                </h6>
                                <small class="text-muted d-block text-truncate">{{ $teacher->{'title_' . $locale} ?: 'Mugallym' }}</small>
                                <div class="d-flex align-items-center gap-1 text-warning small mt-1">
                                    <i class="bi bi-star-fill"></i>
                                    <span class="text-dark fw-bold">{{ number_format($teacher->rating, 1) }}</span>
                                    <span class="text-muted" style="font-size: 0.725rem;">({{ $teacher->reviews_count }})</span>
                                </div>
                            </div>
                        </div>

                        <div class="small text-muted mb-3">
                            <div class="d-flex align-items-center gap-2 mb-1 text-truncate">
                                <i class="bi bi-building text-primary"></i>
                                <span class="text-truncate">{{ $teacher->institution?->{'name_' . $locale} ?? '—' }}</span>
                            </div>
                            @if($teacher->department)
                                <div class="d-flex align-items-center gap-2 mb-1 text-truncate">
                                    <i class="bi bi-diagram-3 text-secondary"></i>
                                    <span class="text-truncate">{{ $teacher->department->{'name_' . $locale} }}</span>
                                </div>
                            @endif
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock-history text-secondary"></i>
                                <span>{{ $teacher->experience_years }} {{ $texts['exp_years'][$locale] }}</span>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @foreach($teacher->lessons->take(2) as $tLesson)
                                <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.72rem;">
                                    {{ $tLesson->{'name_' . $locale} }}
                                </span>
                            @endforeach
                            @if($teacher->lessons->count() > 2)
                                <span class="badge bg-light text-muted border fw-normal" style="font-size: 0.72rem;">
                                    +{{ $teacher->lessons->count() - 2 }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <a href="{{ route('teachers.show', $teacher->id) }}" class="btn btn-light btn-sm flex-grow-1 rounded-pill border fw-semibold">
                            {{ $texts['view_profile'][$locale] }}
                        </a>
                        @auth
                            <a href="{{ route('chat.start', $teacher->id) }}" class="btn btn-primary btn-sm rounded-pill px-3" title="{{ $texts['send_message'][$locale] }}">
                                <i class="bi bi-chat-dots-fill"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3" title="{{ $texts['send_message'][$locale] }}">
                                <i class="bi bi-chat-dots"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5 text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                    <i class="bi bi-person-x text-muted fs-1"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">{{ $texts['empty'][$locale] }}</h5>
                <a href="{{ route('teachers.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 mt-2">
                    {{ $texts['reset_btn'][$locale] }}
                </a>
            </div>
        @endforelse
    </div>

    @if($teachers->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $teachers->links() }}
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
</style>
@endsection