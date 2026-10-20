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
    <title>404 - {{ $locale === 'tk' ? 'Sahypa tapylmady' : ($locale === 'ru' ? 'Страница не найдена' : 'Page Not Found') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <style>
        body {
            background-color: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .error-code {
            font-size: 8rem;
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>
    <div class="text-center px-3 animate__animated animate__fadeIn">
        <div class="error-code">404</div>
        <h2 class="fw-bold text-dark mt-2">
            {{ $locale === 'tk' ? 'Sahypa tapylmady' : ($locale === 'ru' ? 'Страница не найдена' : 'Page Not Found') }}
        </h2>
        <p class="text-muted mb-4 mx-auto" style="max-width: 480px;">
            {{ $locale === 'tk' ? 'Gözleýän sahypaňyz ýok ýa-da adresi üýtgedilen bolmagy mümkin.' : ($locale === 'ru' ? 'Запрашиваемая вами страница не существует или была перемещена.' : 'The page you are looking for does not exist or has been moved.') }}
        </p>
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2">
                <i class="bi bi-house-door-fill me-1"></i> {{ $locale === 'tk' ? 'Baş sahypa dolan' : ($locale === 'ru' ? 'На главную' : 'Back to Home') }}
            </a>
            <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary px-4 py-2">
                <i class="bi bi-search me-1"></i> {{ $locale === 'tk' ? 'Mugallymlar' : ($locale === 'ru' ? 'Преподаватели' : 'Browse Teachers') }}
            </a>
        </div>
    </div>
</body>
</html>