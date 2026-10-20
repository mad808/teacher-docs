@extends('front.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'badge' => [
            'tk' => 'Ýokary bilim we ylym ulgamy',
            'ru' => 'Система высшего образования и науки',
            'en' => 'Higher Education & Science Portal',
        ],
        'hero_title_1' => [
            'tk' => 'Türkmenistanyň ylmy we bilimi —',
            'ru' => 'Наука и образование Туркменистана —',
            'en' => 'Higher Education of Turkmenistan —',
        ],
        'hero_title_2' => [
            'tk' => 'indi bir bitewi platformada',
            'ru' => 'теперь на единой платформе',
            'en' => 'all in one unified platform',
        ],
        'hero_desc' => [
            'tk' => 'Ýokary okuw mekdepleriniň professor-mugallymlaryny gözläň, talyplar bilen göni aragatnaşyk guruň we ylmy leksiýalary, okuw gollanmalaryny onlaýn ýükläp alyň.',
            'ru' => 'Находите ведущих преподавателей вузов страны, общайтесь напрямую в чате и скачивайте авторские учебные материалы.',
            'en' => 'Find verified university professors, communicate directly in chat, and access official academic resources.',
        ],
        'search_placeholder' => [
            'tk' => 'Mugallymyň ady, ders ýa-da okuw jaýy...',
            'ru' => 'Преподаватель, предмет или вуз...',
            'en' => 'Teacher name, subject, or university...',
        ],
        'search_btn' => [
            'tk' => 'Gözleg',
            'ru' => 'Поиск',
            'en' => 'Search',
        ],
        'teachers_label' => [
            'tk' => 'professor-mugallym',
            'ru' => 'преподавателей',
            'en' => 'educators',
        ],
        'institutions_label' => [
            'tk' => 'ýokary okuw jaýy',
            'ru' => 'учебных заведений',
            'en' => 'institutions',
        ],
        'documents_label' => [
            'tk' => 'okuw gollanmasy',
            'ru' => 'учебных материалов',
            'en' => 'documents',
        ],
        'lessons_label' => [
            'tk' => 'ylmy ugur we ders',
            'ru' => 'учебных дисциплин',
            'en' => 'subjects',
        ],
        'catalog_title' => [
            'tk' => 'Mugallymlar katalogy',
            'ru' => 'Каталог преподавателей',
            'en' => 'Teachers Directory',
        ],
        'catalog_desc' => [
            'tk' => 'Reýtingi, ylmy derejesi we berýän dersleri boýunça ýokary baha berlen mugallymlar.',
            'ru' => 'Ведущие преподаватели с подтвержденной квалификацией и высоким рейтингом.',
            'en' => 'Top rated professors filtered by academic degree and verified status.',
        ],
        'view_all' => [
            'tk' => 'Ählisini görmek',
            'ru' => 'Смотреть все',
            'en' => 'View all',
        ],
        'subjects_title' => [
            'tk' => 'Ylmy ugurlar we dersler',
            'ru' => 'Дисциплины и направления',
            'en' => 'Academic Disciplines',
        ],
        'inst_title' => [
            'tk' => 'Ýokary okuw mekdepleri',
            'ru' => 'Университеты и институты',
            'en' => 'Universities & Institutes',
        ],
        'docs_title' => [
            'tk' => 'Täze neşirler we okuw materiallary',
            'ru' => 'Новые материалы и публикации',
            'en' => 'Recently Published Materials',
        ],
        'docs_desc' => [
            'tk' => 'Mugallymlaryň talyplar üçin taýýarlan iň soňky elektron gollanmalary.',
            'ru' => 'Свежие электронные пособия и лекции, опубликованные преподавателями.',
            'en' => 'Recent electronic study guides and lecture materials from educators.',
        ],
        'how_title' => [
            'tk' => 'Platforma nähili işleýär',
            'ru' => 'Как работает платформа',
            'en' => 'How the platform works',
        ],
        'how_desc' => [
            'tk' => 'Üç ýönekeý ädimde ylym we bilim bilen göni baglanyşyň.',
            'ru' => 'Три простых шага для доступа к академическим знаниям.',
            'en' => 'Three simple steps to access academic knowledge directly.',
        ],
        'step1_title' => [
            'tk' => '01. Mugallymy saýlaň',
            'ru' => '01. Выберите преподавателя',
            'en' => '01. Choose a Teacher',
        ],
        'step1_desc' => [
            'tk' => 'Okuw jaýy, kafedrasy ýa-da okadýan dersi boýunça mugallymy tapyň.',
            'ru' => 'Найдите преподавателя по университету, кафедре или дисциплине.',
            'en' => 'Find the educator by university, department, or subject.',
        ],
        'step2_title' => [
            'tk' => '02. Göni habarlaşyň',
            'ru' => '02. Напишите напрямую',
            'en' => '02. Direct Messaging',
        ],
        'step2_desc' => [
            'tk' => 'Soraglaryňyzy bermek üçin platformanyň gurlan çaty arkaly ýazyşyň.',
            'ru' => 'Задавайте вопросы и консультируйтесь через встроенный чат.',
            'en' => 'Ask academic questions via built-in private messaging.',
        ],
        'step3_title' => [
            'tk' => '03. Materiallary peýdalanyň',
            'ru' => '03. Скачивайте материалы',
            'en' => '03. Download Resources',
        ],
        'step3_desc' => [
            'tk' => 'Mugallymyň profilindäki leksiýalary we okuw gollanmalaryny erkin ýükläp alyň.',
            'ru' => 'Скачивайте учебные пособия и лекции прямо из профиля автора.',
            'en' => 'Download lectures, notes, and study guides from author profiles.',
        ],
        'cta_title' => [
            'tk' => 'Siz mugallymmy? Platforma agza boluň',
            'ru' => 'Вы преподаватель? Присоединяйтесь',
            'en' => 'Are you an educator? Join our network',
        ],
        'cta_desc' => [
            'tk' => 'Öz şahsy ylmy profiliňizi dörediň, talyplar bilen aragatnaşyk saklaň we awtorlyk okuw gollanmalaryňyzy paýlaşyň.',
            'ru' => 'Создайте подтвержденный профиль, делитесь учебными разработками и оставайтесь на связи со студентами.',
            'en' => 'Create your verified academic profile, share learning resources, and interact with students.',
        ],
        'cta_btn' => [
            'tk' => 'Hasap açmak / Gir',
            'ru' => 'Войти / Зарегистрироваться',
            'en' => 'Sign In / Register',
        ],
    ];
@endphp

@section('content')
<section class="hero-science">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="hero-badge-pill mb-3">
                    <span class="badge-dot"></span>
                    <span>{{ $texts['badge'][$locale] }}</span>
                </div>

                <h1 class="hero-title mb-3">
                    <span class="hero-title-top">{{ $texts['hero_title_1'][$locale] }}</span>
                    <span class="hero-title-bot">{{ $texts['hero_title_2'][$locale] }}</span>
                </h1>

                <p class="hero-lead mb-4">
                    {{ $texts['hero_desc'][$locale] }}
                </p>

                <form action="{{ route('teachers.index') }}" method="GET" class="hero-search-box mb-4">
                    <div class="search-inner">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="q" class="search-input" placeholder="{{ $texts['search_placeholder'][$locale] }}" autocomplete="off">
                        <button type="submit" class="search-btn">
                            <span>{{ $texts['search_btn'][$locale] }}</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <div class="d-flex flex-wrap gap-2 align-items-center small text-muted">
                    <span class="fw-bold text-dark">{{ $locale === 'tk' ? 'Köp gözlenilýän:' : 'Популярно:' }}</span>
                    @foreach($lessons->take(4) as $l)
                        <a href="{{ route('teachers.index', ['lesson_id' => $l->id]) }}" class="hero-tag-link">
                            {{ $l->{'name_' . $locale} }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4 d-none d-lg-block" data-aos="fade-left">
                <div class="year-emblem-card">
                    <!-- <div class="year-num">2026</div> -->
                    <img src="{{ asset('assets/img/legal/emblem-2026.png') }}" alt="2026" class="img-fluid my-2" style="max-height: 110px; object-fit: contain;">
                    <div class="year-text">
                        Garaşsyz, baky Bitarap Türkmenistan &mdash; bedew batly at-myradyň mekany
                    </div>
                    <div class="emblem-divider"></div>
                    <div class="d-flex justify-content-between align-items-center small text-muted w-100">
                        <span>Sanly Bilim</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="stats-band">
    <div class="container">
        <div class="stats-glass-grid">
            <div class="stat-card">
                <div class="stat-icon-plate">
                    <i class="bi bi-person-video3"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-num">{{ number_format($counts['teachers']) }}+</div>
                    <div class="stat-label">{{ $texts['teachers_label'][$locale] }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-plate">
                    <i class="bi bi-building"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-num">{{ number_format($counts['institutions']) }}</div>
                    <div class="stat-label">{{ $texts['institutions_label'][$locale] }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-plate">
                    <i class="bi bi-folder2-open"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-num">{{ number_format($counts['documents']) }}+</div>
                    <div class="stat-label">{{ $texts['documents_label'][$locale] }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-plate">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-num">{{ number_format($counts['lessons']) }}</div>
                    <div class="stat-label">{{ $texts['lessons_label'][$locale] }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($featured_teachers->count() > 0)
<section class="catalog-section">
    <div class="container">
        <div class="section-top-bar">
            <div>
                <h2 class="section-title">{{ $texts['catalog_title'][$locale] }}</h2>
                <p class="section-sub">{{ $texts['catalog_desc'][$locale] }}</p>
            </div>
            <a href="{{ route('teachers.index') }}" class="btn-clean-link">
                <span>{{ $texts['view_all'][$locale] }}</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($featured_teachers as $teacher)
                <div class="col-12 col-sm-6 col-lg-3" data-aos="fade-up">
                    <article class="academic-card h-100">
                        <div class="card-cover-plate">
                            <div class="card-cover-inner">
                                <span class="cover-org-label">{{ Str::limit($teacher->institution?->{'name_' . $locale} ?? 'Türkmenistan', 32) }}</span>
                                <div class="cover-avatar-wrap">
                                    @if($teacher->user->avatar)
                                        <img src="{{ asset('storage/' . $teacher->user->avatar) }}" class="cover-avatar-img" alt="{{ $teacher->user->name }}">
                                    @else
                                        <div class="cover-avatar-stub">
                                            {{ strtoupper(substr($teacher->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <span class="cover-title">{{ $teacher->user->name }}</span>
                                <span class="cover-meta">{{ $teacher->{'title_' . $locale} ?: 'Mugallym' }}</span>
                            </div>
                        </div>

                        <div class="card-body-block">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge-rating">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <strong>{{ number_format($teacher->rating, 1) }}</strong>
                                    <span class="text-muted">({{ $teacher->reviews_count }})</span>
                                </span>
                                <span class="badge-exp">{{ $teacher->experience_years }} ýyl tejribe</span>
                            </div>

                            <div class="d-flex flex-wrap gap-1 mb-3">
                                @foreach($teacher->lessons->take(2) as $tLesson)
                                    <span class="subject-chip">{{ $tLesson->{'name_' . $locale} }}</span>
                                @endforeach
                            </div>

                            <div class="card-actions-grid">
                                <a href="{{ route('teachers.show', $teacher->id) }}" class="btn-card-profile">
                                    Profil
                                </a>
                                @auth
                                    <a href="{{ route('chat.start', $teacher->id) }}" class="btn-card-chat" title="Hat ýaz">
                                        <i class="bi bi-chat-dots-fill"></i>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn-card-chat" title="Hat ýaz">
                                        <i class="bi bi-chat-dots"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($lessons->count() > 0)
<section class="section-surface border-top">
    <div class="container">
        <div class="section-top-bar">
            <div>
                <h2 class="section-title">{{ $texts['subjects_title'][$locale] }}</h2>
                <p class="section-sub">{{ $locale === 'tk' ? 'Öz gyzyklanýan ylmy ugruňyz boýunça mugallymlary saýlaň' : 'Выберите преподавателя по интересующему вас направлению' }}</p>
            </div>
            <a href="{{ route('teachers.index') }}" class="btn-clean-link">
                <span>{{ $texts['view_all'][$locale] }}</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-2 g-md-3">
            @foreach($lessons as $lesson)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('teachers.index', ['lesson_id' => $lesson->id]) }}" class="discipline-pill">
                        <span class="discipline-icon">
                            <i class="bi {{ $lesson->icon ?: 'bi-journal-bookmark' }}"></i>
                        </span>
                        <div class="discipline-info">
                            <div class="discipline-name">{{ $lesson->{'name_' . $locale} }}</div>
                            <div class="discipline-count">{{ $lesson->teachers_count }} mugallym</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($institutions->count() > 0)
<section class="section-surface border-top">
    <div class="container">
        <div class="section-top-bar">
            <div>
                <h2 class="section-title">{{ $texts['inst_title'][$locale] }}</h2>
                <p class="section-sub">{{ $locale === 'tk' ? 'Ýurdumyzyň döwlet uniwersitetleri we institutlary' : 'Государственные вузы и институты страны' }}</p>
            </div>
            <a href="{{ route('teachers.index') }}" class="btn-clean-link">
                <span>{{ $texts['view_all'][$locale] }}</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-3">
            @foreach($institutions as $inst)
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('teachers.index', ['institution_id' => $inst->id]) }}" class="inst-box">
                        <div class="inst-logo-wrap">
                            @if($inst->logo)
                                <img src="{{ asset('storage/' . $inst->logo) }}" class="inst-logo" alt="">
                            @else
                                <i class="bi bi-building inst-stub-icon"></i>
                            @endif
                        </div>
                        <div class="inst-meta">
                            <div class="inst-name">{{ $inst->{'name_' . $locale} }}</div>
                            <div class="inst-city">{{ $inst->city ?: 'Turkmenistan' }} &bull; {{ $inst->teacher_profiles_count }} mugallym</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($latest_documents->count() > 0)
<section class="section-surface border-top">
    <div class="container">
        <div class="section-top-bar">
            <div>
                <h2 class="section-title">{{ $texts['docs_title'][$locale] }}</h2>
                <p class="section-sub">{{ $texts['docs_desc'][$locale] }}</p>
            </div>
            <a href="{{ route('documents.index') }}" class="btn-clean-link">
                <span>{{ $texts['view_all'][$locale] }}</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($latest_documents as $doc)
                @php
                    $ext = strtolower($doc->file_extension);
                    $extColor = match($ext) {
                        'pdf' => '#dc3545',
                        'doc', 'docx' => '#0d6efd',
                        'ppt', 'pptx' => '#fd7e14',
                        'xls', 'xlsx' => '#198754',
                        default => '#6c757d',
                    };
                @endphp
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="doc-card">
                        <div class="doc-card-head">
                            <span class="doc-ext-badge" style="background-color: {{ $extColor }};">
                                {{ $ext }}
                            </span>
                            <span class="doc-downloads">
                                <i class="bi bi-download me-1"></i>{{ $doc->downloads_count }}
                            </span>
                        </div>

                        <div class="doc-card-body">
                            <div class="doc-title">{{ $doc->{'title_' . $locale} }}</div>
                            <div class="doc-author">
                                <i class="bi bi-person-circle me-1"></i>{{ $doc->teacherProfile?->user?->name ?? 'Mugallym' }}
                                @if($doc->lesson)
                                    &bull; <span>{{ $doc->lesson->{'name_' . $locale} }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="doc-card-foot">
                            <span class="doc-size">{{ round($doc->file_size / 1024, 1) }} KB</span>
                            <a href="{{ route('documents.download', $doc->id) }}" class="doc-download-btn">
                                <i class="bi bi-download me-1"></i> Ýükle
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="how-section border-top">
    <div class="container">
        <div class="section-top-bar text-center justify-content-center flex-column mb-5">
            <h2 class="section-title mb-2">{{ $texts['how_title'][$locale] }}</h2>
            <p class="section-sub mb-0">{{ $texts['how_desc'][$locale] }}</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="how-step-card">
                    <div class="step-num-plate">01</div>
                    <div class="step-icon"><i class="bi bi-person-check-fill"></i></div>
                    <h5 class="step-title">{{ $texts['step1_title'][$locale] }}</h5>
                    <p class="step-desc">{{ $texts['step1_desc'][$locale] }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="how-step-card">
                    <div class="step-num-plate">02</div>
                    <div class="step-icon"><i class="bi bi-chat-dots-fill"></i></div>
                    <h5 class="step-title">{{ $texts['step2_title'][$locale] }}</h5>
                    <p class="step-desc">{{ $texts['step2_desc'][$locale] }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="how-step-card">
                    <div class="step-num-plate">03</div>
                    <div class="step-icon"><i class="bi bi-cloud-arrow-down-fill"></i></div>
                    <h5 class="step-title">{{ $texts['step3_title'][$locale] }}</h5>
                    <p class="step-desc">{{ $texts['step3_desc'][$locale] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-banner">
    <div class="container">
        <div class="cta-box">
            <div class="row align-items-center justify-content-between g-4">
                <div class="col-lg-8 text-center text-lg-start">
                    <div class="cta-badge mb-2">Mugallymlar üçin</div>
                    <h3 class="cta-heading mb-2">{{ $texts['cta_title'][$locale] }}</h3>
                    <p class="cta-sub mb-0">{{ $texts['cta_desc'][$locale] }}</p>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    @auth
                        @if(auth()->user()->isTeacher())
                            <a href="{{ route('teacher.portal.dashboard') }}" class="btn-gold-pill">
                                <i class="bi bi-person-workspace me-1"></i> Mugallym otagy
                            </a>
                        @else
                            <a href="{{ route('teachers.index') }}" class="btn-gold-pill">
                                <i class="bi bi-search me-1"></i> Mugallymlary gözle
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-gold-pill">
                            <i class="bi bi-box-arrow-in-right me-1"></i> {{ $texts['cta_btn'][$locale] }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .hero-science {
        background: linear-gradient(180deg, #ffffff 0%, #f4f6f8 100%);
        padding: 48px 0 36px 0;
        position: relative;
    }
    @media (min-width: 992px) {
        .hero-science {
            padding: 72px 0 48px 0;
        }
    }
    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(16, 98, 72, 0.08);
        color: var(--brand-primary);
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }
    .badge-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--brand-accent);
    }
    .hero-title {
        font-weight: 900;
        letter-spacing: -0.03em;
        line-height: 1.15;
    }
    .hero-title-top {
        display: block;
        color: var(--ink);
        font-size: 1.8rem;
    }
    .hero-title-bot {
        display: block;
        color: var(--brand-primary);
        font-size: 2.1rem;
    }
    @media (min-width: 768px) {
        .hero-title-top { font-size: 2.3rem; }
        .hero-title-bot { font-size: 2.8rem; }
    }
    .hero-lead {
        font-size: 1rem;
        color: var(--ink-muted);
        line-height: 1.6;
        max-width: 620px;
    }
    .hero-search-box {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-radius: 16px;
        padding: 6px;
        box-shadow: 0 10px 25px rgba(16, 98, 72, 0.08);
        max-width: 600px;
    }
    .search-inner {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .search-icon {
        color: var(--brand-primary);
        font-size: 1.25rem;
        padding-left: 10px;
    }
    .search-input {
        border: 0;
        outline: none;
        box-shadow: none;
        flex: 1;
        font-size: 0.95rem;
        padding: 10px 6px;
        background: transparent;
        color: var(--ink);
    }
    .search-btn {
        background: var(--brand-primary);
        color: #ffffff;
        border: 0;
        border-radius: 12px;
        padding: 10px 20px;
        font-size: 0.9rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
        flex-shrink: 0;
    }
    .search-btn:hover {
        background: var(--brand-hover);
    }
    .hero-tag-link {
        color: var(--ink-muted);
        text-decoration: none;
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.08);
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 0.78rem;
        transition: all 0.15s ease;
    }
    .hero-tag-link:hover {
        color: var(--brand-primary);
        border-color: var(--brand-primary);
    }
    .year-emblem-card {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-radius: 20px;
        padding: 28px;
        text-align: center;
        box-shadow: 0 12px 30px rgba(16, 98, 72, 0.06);
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .emblem-orb {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: rgba(16, 98, 72, 0.08);
        color: var(--brand-primary);
        font-size: 1.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }
    .year-num {
        font-size: 2.2rem;
        font-weight: 900;
        color: black;
        line-height: 1;
        letter-spacing: -0.02em;
    }
    .year-text {
        font-size: 0.85rem;
        color: var(--ink-muted);
        line-height: 1.45;
        margin: 10px 0 14px 0;
        font-weight: 600;
    }
    .emblem-divider {
        width: 100%;
        height: 1px;
        background: rgba(0, 0, 0, 0.08);
        margin-bottom: 14px;
    }
    .stats-band {
        background: var(--bg-canvas);
        padding: 24px 0 36px 0;
    }
    .stats-glass-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    @media (min-width: 992px) {
        .stats-glass-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
    }
    .stat-card {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-radius: 16px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }
    .stat-icon-plate {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(16, 98, 72, 0.08);
        color: var(--brand-primary);
        font-size: 1.35rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-num {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--ink);
        line-height: 1;
        letter-spacing: -0.02em;
    }
    .stat-label {
        font-size: 0.78rem;
        color: var(--ink-muted);
        font-weight: 600;
        margin-top: 4px;
    }
    .catalog-section, .section-surface, .how-section {
        padding: 48px 0;
    }
    .section-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 24px;
    }
    .section-title {
        font-weight: 800;
        font-size: 1.45rem;
        color: var(--ink);
        margin-bottom: 4px;
        letter-spacing: -0.02em;
    }
    @media (min-width: 768px) {
        .section-title { font-size: 1.75rem; }
    }
    .section-sub {
        font-size: 0.88rem;
        color: var(--ink-muted);
        margin-bottom: 0;
    }
    .btn-clean-link {
        color: var(--brand-primary);
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-radius: 100px;
        white-space: nowrap;
        transition: all 0.15s ease;
    }
    .btn-clean-link:hover {
        background: var(--brand-primary);
        color: #ffffff;
    }
    .academic-card {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .academic-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(16, 98, 72, 0.1);
    }
    .card-cover-plate {
        background: linear-gradient(135deg, #106248 0%, #0d4633 100%);
        padding: 16px 14px;
        color: #ffffff;
        text-align: center;
        position: relative;
    }
    .cover-org-label {
        display: block;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        opacity: 0.8;
        margin-bottom: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cover-avatar-wrap {
        margin: 0 auto 10px auto;
        width: 60px;
        height: 60px;
    }
    .cover-avatar-img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.4);
    }
    .cover-avatar-stub {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
        font-size: 1.3rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(255, 255, 255, 0.4);
    }
    .cover-title {
        display: block;
        font-weight: 800;
        font-size: 0.95rem;
        color: #ffffff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cover-meta {
        display: block;
        font-size: 0.75rem;
        color: #a3cfbb;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .card-body-block {
        padding: 14px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .badge-rating {
        font-size: 0.78rem;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        color: var(--ink);
    }
    .badge-exp {
        font-size: 0.7rem;
        background: #f1f5f3;
        color: var(--ink-muted);
        padding: 2px 8px;
        border-radius: 100px;
        font-weight: 600;
    }
    .subject-chip {
        background: #eef2f1;
        color: var(--ink);
        font-size: 0.7rem;
        padding: 2px 7px;
        border-radius: 4px;
        font-weight: 600;
    }
    .card-actions-grid {
        margin-top: auto;
        display: flex;
        gap: 6px;
        padding-top: 10px;
        border-top: 1px solid rgba(0, 0, 0, 0.06);
    }
    .btn-card-profile {
        flex: 1;
        text-align: center;
        background: var(--bg-canvas);
        color: var(--ink);
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        transition: all 0.15s ease;
    }
    .btn-card-profile:hover {
        background: #e2e8e5;
    }
    .btn-card-chat {
        width: 36px;
        height: 34px;
        border-radius: 8px;
        background: var(--brand-primary);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 0.85rem;
        transition: background 0.15s ease;
    }
    .btn-card-chat:hover {
        background: var(--brand-hover);
        color: #ffffff;
    }
    .discipline-pill {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-radius: 12px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .discipline-pill:hover {
        border-color: var(--brand-primary);
        background: rgba(16, 98, 72, 0.03);
    }
    .discipline-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: rgba(16, 98, 72, 0.08);
        color: var(--brand-primary);
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .discipline-name {
        font-weight: 700;
        font-size: 0.84rem;
        color: var(--ink);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .discipline-count {
        font-size: 0.72rem;
        color: var(--ink-muted);
    }
    .inst-box {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-radius: 14px;
        padding: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        height: 100%;
        transition: all 0.15s ease;
    }
    .inst-box:hover {
        border-color: var(--brand-primary);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
    }
    .inst-logo-wrap {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        background: #f4f6f8;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .inst-logo {
        max-width: 38px;
        max-height: 38px;
        object-fit: contain;
    }
    .inst-stub-icon {
        font-size: 1.3rem;
        color: var(--brand-primary);
    }
    .inst-name {
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--ink);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
    }
    .inst-city {
        font-size: 0.72rem;
        color: var(--ink-muted);
        margin-top: 3px;
    }
    .doc-card {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-radius: 14px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .doc-card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .doc-ext-badge {
        color: #ffffff;
        font-size: 0.65rem;
        text-transform: uppercase;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 4px;
    }
    .doc-downloads {
        font-size: 0.74rem;
        color: var(--ink-muted);
    }
    .doc-title {
        font-weight: 800;
        font-size: 0.92rem;
        color: var(--ink);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 6px;
        line-height: 1.35;
    }
    .doc-author {
        font-size: 0.78rem;
        color: var(--ink-muted);
        margin-bottom: 12px;
    }
    .doc-card-foot {
        margin-top: auto;
        padding-top: 10px;
        border-top: 1px solid rgba(0, 0, 0, 0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .doc-size {
        font-size: 0.75rem;
        color: var(--ink-muted);
    }
    .doc-download-btn {
        background: rgba(16, 98, 72, 0.08);
        color: var(--brand-primary);
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        padding: 4px 12px;
        border-radius: 100px;
        transition: all 0.15s ease;
    }
    .doc-download-btn:hover {
        background: var(--brand-primary);
        color: #ffffff;
    }
    .how-step-card {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-radius: 16px;
        padding: 24px;
        position: relative;
        height: 100%;
    }
    .step-num-plate {
        font-size: 1.1rem;
        font-weight: 900;
        color: var(--brand-accent);
        margin-bottom: 12px;
    }
    .step-icon {
        font-size: 1.8rem;
        color: var(--brand-primary);
        margin-bottom: 10px;
    }
    .step-title {
        font-weight: 800;
        font-size: 1rem;
        color: var(--ink);
        margin-bottom: 6px;
    }
    .step-desc {
        font-size: 0.85rem;
        color: var(--ink-muted);
        margin-bottom: 0;
        line-height: 1.5;
    }
    .cta-banner {
        padding: 16px 0 48px 0;
    }
    .cta-box {
        background: linear-gradient(135deg, #0d4633 0%, #082d21 100%);
        border-radius: 20px;
        padding: 32px 24px;
        color: #ffffff;
        border: 1px solid rgba(201, 151, 56, 0.3);
    }
    @media (min-width: 992px) {
        .cta-box {
            padding: 44px 48px;
        }
    }
    .cta-badge {
        display: inline-block;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--brand-accent);
        font-weight: 800;
    }
    .cta-heading {
        font-weight: 900;
        font-size: 1.4rem;
        letter-spacing: -0.02em;
    }
    @media (min-width: 768px) {
        .cta-heading { font-size: 1.8rem; }
    }
    .cta-sub {
        font-size: 0.9rem;
        color: #a3cfbb;
        max-width: 580px;
    }
    .btn-gold-pill {
        background: var(--brand-accent);
        color: #0a1b16;
        text-decoration: none;
        font-weight: 800;
        font-size: 0.92rem;
        padding: 12px 28px;
        border-radius: 100px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: transform 0.15s ease, background 0.15s ease;
        box-shadow: 0 4px 14px rgba(201, 151, 56, 0.35);
    }
    .btn-gold-pill:hover {
        background: #dba748;
        color: #0a1b16;
        transform: translateY(-2px);
    }
</style>
@endsection