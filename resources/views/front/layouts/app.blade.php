@php
    $locale = app()->getLocale();
    $setting = \App\Models\Setting::first();
    $siteName = $setting?->{'site_name_' . $locale} ?? 'ProTeachers';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteName)</title>

    @if($setting?->favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $setting->favicon) }}">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">

    <style>
        :root {
            --bg-canvas: #f4f6f8;
            --brand-primary: #106248;
            --brand-hover: #0a4733;
            --brand-accent: #c99738;
            --ink: #162421;
            --ink-muted: #5e6f6a;
            --surface: #ffffff;
            --border-soft: rgba(16, 98, 72, 0.12);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-canvas);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 1040;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-soft);
        }

        .header-utility {
            background: #0d4633;
            color: #d1e7dd;
            padding: 4px 0;
            font-size: 0.75rem;
        }

        .lang-switch a {
            color: #a3cfbb;
            text-decoration: none;
            padding: 2px 7px;
            font-weight: 600;
            border-radius: 4px;
            letter-spacing: 0.04em;
        }

        .lang-switch a.active, .lang-switch a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.18);
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-plate {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: linear-gradient(135deg, #106248 0%, #083c2c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.4rem;
            box-shadow: 0 4px 10px rgba(16, 98, 72, 0.25);
        }

        .brand-name {
            font-weight: 800;
            font-size: 1.15rem;
            line-height: 1.15;
            color: var(--ink);
            letter-spacing: -0.02em;
        }

        .brand-tag {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--brand-accent);
            font-weight: 700;
        }

        .tg-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            background: #eef2f1;
            padding: 4px;
            border-radius: 100px;
        }

        .tg-nav-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ink-muted);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .tg-nav-link:hover {
            color: var(--ink);
            background: rgba(255, 255, 255, 0.6);
        }

        .tg-nav-link.active {
            color: #ffffff;
            background: var(--brand-primary);
            box-shadow: 0 2px 6px rgba(16, 98, 72, 0.3);
        }

        .site-footer {
            background: #0a1b16;
            color: #9cb1aa;
            margin-top: auto;
            border-top: 3px solid var(--brand-accent);
        }

        .footer-mast {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 32px;
        }

        .footer-emblem {
            width: 58px;
            height: 58px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-accent);
            font-size: 1.8rem;
            border: 1px solid rgba(201, 151, 56, 0.3);
        }

        .footer-col-title {
            color: #ffffff;
            font-size: 0.78rem;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.1em;
            margin-bottom: 16px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 9px;
            font-size: 0.85rem;
        }

        .footer-links a {
            color: #9cb1aa;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .footer-links a:hover {
            color: #ffffff;
        }

        .footer-base {
            padding: 20px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 0.8rem;
            color: #728a82;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .toast-top-center {
            top: 20px !important;
            right: 0 !important;
            width: 100% !important;
        }

        #toast-container > div {
            margin: 0 auto 10px auto !important;
            border-radius: 8px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            opacity: 1 !important;
        }
    </style>
    @yield('styles')
</head>
<body>
    @include('front.partials.navbar')

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('front.partials.footer')

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js.js') }}"></script>

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "timeOut": "4000",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        AOS.init({ once: true });
    </script>
    @yield('scripts')
</body>
</html>