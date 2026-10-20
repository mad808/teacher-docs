@php
    $locale = app()->getLocale();
    $setting = \App\Models\Setting::first();
    $siteName = $setting?->{'site_name_' . $locale} ?? 'ProTeachers';
    $pendingDocsCount = \App\Models\Document::where('status', 0)->count();
@endphp

<aside id="sidebar" class="d-flex flex-column p-3 flex-shrink-0 shadow">
    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 mb-4 text-white text-decoration-none px-2">
        @if($setting?->logo)
            <img src="{{ asset('storage/' . $setting->logo) }}" height="38" alt="{{ $siteName }}">
        @else
            <div class="rounded-circle bg-primary p-2 d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px;">
                <i class="bi bi-mortarboard-fill fs-5"></i>
            </div>
        @endif
        <div class="d-flex flex-column">
            <span class="fs-5 fw-bold tracking-tight text-white lh-1">{{ $siteName }}</span>
            <span class="text-muted text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.1rem;">Admin Portal</span>
        </div>
    </a>

    <div class="text-uppercase text-secondary fw-bold px-3 mb-2" style="font-size: 0.68rem; letter-spacing: 0.05rem;">
        {{ __('Navigation') }}
    </div>

    <ul class="nav nav-pills flex-column mb-auto gap-1">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>{{ __('Dashboard') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.teachers.index') }}" class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                <i class="bi bi-person-video3"></i>
                <span>{{ __('Teachers') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>{{ __('Students') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.institutions.index') }}" class="nav-link {{ request()->routeIs('admin.institutions.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>{{ __('Institutions') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.departments.index') }}" class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3-fill"></i>
                <span>{{ __('Departments') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.lessons.index') }}" class="nav-link {{ request()->routeIs('admin.lessons.*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span>{{ __('Lessons') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.documents.index') }}" class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>{{ __('Documents') }}</span>
                </div>
                @if($pendingDocsCount > 0)
                    <span class="badge bg-warning text-dark rounded-pill">{{ $pendingDocsCount }}</span>
                @endif
            </a>
        </li>
        <li>
            <a href="{{ route('admin.conversations.index') }}" class="nav-link {{ request()->routeIs('admin.conversations.*') ? 'active' : '' }}">
                <i class="bi bi-chat-left-dots-fill"></i>
                <span>{{ __('Total Chats') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i>
                <span>{{ __('Settings') }}</span>
            </a>
        </li>
    </ul>

    <hr class="border-secondary border-opacity-25 my-3">

    <div class="d-flex flex-column gap-2 px-1">
        <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm text-light text-start d-flex align-items-center gap-2">
            <i class="bi bi-box-arrow-up-right"></i>
            <span>{{ __('View Website') }}</span>
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm w-100 text-start d-flex align-items-center gap-2">
                <i class="bi bi-power"></i>
                <span>{{ __('Logout') }}</span>
            </button>
        </form>
    </div>
</aside>