@php
    $locale = app()->getLocale();
    $setting = \App\Models\Setting::first();
    $siteName = $setting?->{'site_name_' . $locale} ?? 'ProTeachers';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Dashboard')) - {{ $siteName }}</title>

    @if($setting?->favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $setting->favicon) }}">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
        }
        #sidebar {
            width: 260px;
            min-height: 100vh;
            background: #0f172a;
            color: #94a3b8;
            transition: all 0.3s;
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        #sidebar .nav-link {
            color: #94a3b8;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 0.925rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: background 0.2s, color 0.2s;
        }
        #sidebar .nav-link:hover {
            color: #ffffff;
            background-color: #1e293b;
        }
        #sidebar .nav-link.active {
            color: #ffffff;
            background-color: #2563eb;
            font-weight: 600;
        }
        .admin-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }
        .toast-top-center {
            top: 20px !important;
            right: 0 !important;
            width: 100% !important;
        }
        #toast-container > div {
            margin: 0 auto 10px auto !important;
            border-radius: 8px !important;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important;
            opacity: 1 !important;
        }
    </style>
    @yield('styles')
</head>
<body class="d-flex">
    @include('admin.partials.sidebar')

    <div class="admin-content">
        @include('admin.partials.header')

        <main class="p-4 flex-grow-1">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
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

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('d-none');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>