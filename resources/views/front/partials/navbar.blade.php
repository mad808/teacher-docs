@php
    $locale = app()->getLocale();
    $setting = \App\Models\Setting::first();
    $siteName = $setting?->{'site_name_' . $locale} ?? 'ProTeachers';
    $unreadCount = auth()->check() ? \App\Models\Message::whereHas('conversation', function ($q) {
        $q->where('teacher_id', auth()->id())->orWhere('student_id', auth()->id());
    })->where('sender_id', '!=', auth()->id())->whereNull('read_at')->count() : 0;
@endphp

<header class="site-header">
    <div class="header-utility">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="d-flex align-items-center gap-2">
                <i class="bi bi-patch-check-fill" style="color: var(--brand-accent);"></i>
                <span class="d-none d-sm-inline">{{ $locale === 'tk' ? 'Türkmenistanyň ýokary okuw mekdepleriniň maglumat binýady' : ($locale === 'ru' ? 'Единая образовательная база преподавателей Туркменистана' : 'Verified Educational Portal of Turkmenistan') }}</span>
            </span>

            <nav class="lang-switch d-flex align-items-center gap-1">
                <a href="{{ route('locale.switch', 'tk') }}" class="{{ $locale === 'tk' ? 'active' : '' }}">TM</a>
                <span class="opacity-25">·</span>
                <a href="{{ route('locale.switch', 'ru') }}" class="{{ $locale === 'ru' ? 'active' : '' }}">RU</a>
                <span class="opacity-25">·</span>
                <a href="{{ route('locale.switch', 'en') }}" class="{{ $locale === 'en' ? 'active' : '' }}">EN</a>
            </nav>
        </div>
    </div>

    <div class="container py-2">
        <div class="d-flex align-items-center justify-content-between gap-3">
            <a class="brand-box" href="{{ route('home') }}">
                @if($setting?->logo)
                    <img src="{{ asset('storage/' . $setting->logo) }}" height="44" alt="{{ $siteName }}">
                @else
                    <div class="brand-plate">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="brand-name">ProTeachers</span>
                        <span class="brand-tag">Mugallymlar &middot; Bilim</span>
                    </div>
                @endif
            </a>

            <nav class="tg-nav d-none d-md-flex">
                <a class="tg-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    <i class="bi bi-house-door"></i>
                    <span>{{ $locale === 'tk' ? 'Baş sahypa' : ($locale === 'ru' ? 'Главная' : 'Home') }}</span>
                </a>
                <a class="tg-nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}" href="{{ route('teachers.index') }}">
                    <i class="bi bi-person-video3"></i>
                    <span>{{ $locale === 'tk' ? 'Katalog' : ($locale === 'ru' ? 'Каталог' : 'Teachers') }}</span>
                </a>
                <a class="tg-nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}" href="{{ route('documents.index') }}">
                    <i class="bi bi-folder2-open"></i>
                    <span>{{ $locale === 'tk' ? 'Materiallar' : ($locale === 'ru' ? 'Материалы' : 'Documents') }}</span>
                </a>
            </nav>

            <div class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ route('chat.index') }}" class="btn btn-light position-relative rounded-pill border p-2" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;" title="Çat">
                        <i class="bi bi-chat-dots-fill" style="color: var(--brand-primary);"></i>
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 0.65rem;">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>

                    @if(auth()->user()->isTeacher())
                        <a href="{{ route('teacher.portal.dashboard') }}" class="btn btn-sm rounded-pill px-3 py-1 fw-semibold d-none d-sm-inline-flex align-items-center gap-1 border" style="background: rgba(16, 98, 72, 0.08); color: var(--brand-primary); border-color: rgba(16, 98, 72, 0.25) !important;">
                            <i class="bi bi-person-workspace"></i>
                            <span>{{ $locale === 'tk' ? 'Otag' : ($locale === 'ru' ? 'Кабинет' : 'Portal') }}</span>
                        </a>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm rounded-pill px-3 py-1 fw-semibold d-none d-sm-inline-flex align-items-center gap-1">
                            <i class="bi bi-shield-lock-fill"></i>
                            <span>Admin</span>
                        </a>
                    @endif

                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 border rounded-pill p-1 pe-2" type="button" data-bs-toggle="dropdown">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle object-fit-cover border" width="30" height="30" alt="">
                            @else
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 0.8rem; background: var(--brand-primary);">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="fw-bold small text-dark d-none d-lg-inline">{{ Str::limit(auth()->user()->name, 12) }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2 p-2" style="min-width: 220px;">
                            <li class="px-3 py-2 bg-light rounded-3 mb-2">
                                <div class="fw-bold small text-dark">{{ auth()->user()->name }}</div>
                                <div class="text-muted small" style="font-size: 0.725rem;">{{ auth()->user()->phone }}</div>
                            </li>

                            @if(auth()->user()->isTeacher())
                                <li>
                                    <a class="dropdown-item py-2 rounded-3 small d-flex align-items-center gap-2" href="{{ route('teacher.portal.dashboard') }}">
                                        <i class="bi bi-person-workspace" style="color: var(--brand-primary);"></i> Otag dolandyryş
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 rounded-3 small d-flex align-items-center gap-2" href="{{ route('teacher.portal.documents') }}">
                                        <i class="bi bi-folder2-open" style="color: var(--brand-primary);"></i> Resminamalarym
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                            @endif

                            @if(auth()->user()->isAdmin())
                                <li>
                                    <a class="dropdown-item py-2 rounded-3 small d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-shield-lock-fill text-dark"></i> Admin Panel
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                            @endif

                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 rounded-3 small text-danger d-flex align-items-center gap-2">
                                        <i class="bi bi-box-arrow-right"></i> {{ $locale === 'tk' ? 'Çykmak' : ($locale === 'ru' ? 'Выйти' : 'Logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex align-items-center gap-1">
                        <a href="{{ route('login') }}" class="btn btn-sm rounded-pill px-3 py-2 fw-bold text-dark border bg-light">
                            <i class="bi bi-box-arrow-in-right me-1"></i> {{ $locale === 'tk' ? 'Gir' : ($locale === 'ru' ? 'Вход' : 'Login') }}
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-sm rounded-pill px-3 py-2 fw-bold text-white d-none d-sm-inline-flex" style="background: var(--brand-primary);">
                            {{ $locale === 'tk' ? 'Hasap aç' : ($locale === 'ru' ? 'Регистрация' : 'Register') }}
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <div class="d-md-none pt-2 pb-1">
            <nav class="tg-nav w-100 justify-content-between">
                <a class="tg-nav-link flex-grow-1 justify-content-center {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    <i class="bi bi-house-door"></i>
                    <span>{{ $locale === 'tk' ? 'Esasy' : ($locale === 'ru' ? 'Главная' : 'Home') }}</span>
                </a>
                <a class="tg-nav-link flex-grow-1 justify-content-center {{ request()->routeIs('teachers.*') ? 'active' : '' }}" href="{{ route('teachers.index') }}">
                    <i class="bi bi-person-video3"></i>
                    <span>{{ $locale === 'tk' ? 'Mugallymlar' : ($locale === 'ru' ? 'Каталог' : 'Teachers') }}</span>
                </a>
                <a class="tg-nav-link flex-grow-1 justify-content-center {{ request()->routeIs('documents.*') ? 'active' : '' }}" href="{{ route('documents.index') }}">
                    <i class="bi bi-folder2-open"></i>
                    <span>{{ $locale === 'tk' ? 'Materiallar' : ($locale === 'ru' ? 'Материалы' : 'Docs') }}</span>
                </a>
            </nav>
        </div>
    </div>
</header>