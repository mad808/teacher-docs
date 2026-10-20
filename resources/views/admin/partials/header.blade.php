@php
    $locale = app()->getLocale();
@endphp

<header class="bg-white border-bottom py-2 px-4 d-flex justify-content-between align-items-center shadow-xs sticky-top">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-light btn-sm d-md-none border" id="sidebarToggle" type="button">
            <i class="bi bi-list fs-5"></i>
        </button>
        <div>
            <h5 class="mb-0 fw-bold text-dark">@yield('page_title', __('Dashboard'))</h5>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <div class="dropdown">
            <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center gap-2 border rounded-pill px-3 py-1 shadow-xs" type="button" data-bs-toggle="dropdown">
                <img src="{{ asset('assets/img/flags/' . ($locale === 'tk' ? 'tkm' : ($locale === 'ru' ? 'rus' : 'eng')) . '.png') }}" width="20" height="14" class="rounded" alt="{{ strtoupper($locale) }}">
                <span class="fw-semibold text-uppercase small text-dark">{{ $locale }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 small {{ $locale === 'tk' ? 'active bg-light text-dark fw-bold' : '' }}" href="{{ route('locale.switch', 'tk') }}">
                        <img src="{{ asset('assets/img/flags/tkm.png') }}" width="18" height="12" class="rounded" alt="TK"> Türkmençe
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 small {{ $locale === 'ru' ? 'active bg-light text-dark fw-bold' : '' }}" href="{{ route('locale.switch', 'ru') }}">
                        <img src="{{ asset('assets/img/flags/rus.png') }}" width="18" height="12" class="rounded" alt="RU"> Русский
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 small {{ $locale === 'en' ? 'active bg-light text-dark fw-bold' : '' }}" href="{{ route('locale.switch', 'en') }}">
                        <img src="{{ asset('assets/img/flags/eng.png') }}" width="18" height="12" class="rounded" alt="EN"> English
                    </a>
                </li>
            </ul>
        </div>

        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 border rounded-pill px-3 py-1 shadow-xs" type="button" data-bs-toggle="dropdown">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle object-fit-cover" width="30" height="30" alt="">
                @else
                    <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 0.8rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="text-start d-none d-md-block">
                    <div class="fw-semibold small text-dark lh-1">{{ auth()->user()->name }}</div>
                    <small class="text-muted" style="font-size: 0.7rem;">Admin</small>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
                <li>
                    <a class="dropdown-item py-2 small d-flex align-items-center gap-2" href="{{ route('admin.settings.index') }}">
                        <i class="bi bi-gear text-muted"></i> {{ __('Settings') }}
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 small text-danger d-flex align-items-center gap-2">
                            <i class="bi bi-power"></i> {{ __('Logout') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>