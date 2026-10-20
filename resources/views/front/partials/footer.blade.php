@php
    $locale = app()->getLocale();
    $setting = \App\Models\Setting::first();
    $siteName = $setting?->{'site_name_' . $locale} ?? 'ProTeachers';
    $popularLessons = \App\Models\Lesson::where('status', 1)->take(4)->get();
@endphp

<footer class="footer-academic">
    <div class="container">
        <div class="footer-top-mast">
            <div class="d-flex align-items-center gap-3">
                <div class="mast-emblem">
                    @if($setting?->logo)
                        <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" style="max-width: 32px; max-height: 32px; object-fit: contain;">
                    @elseif($setting?->favicon)
                        <img src="{{ asset('storage/' . $setting->favicon) }}" alt="Icon" style="max-width: 28px; max-height: 28px; object-fit: contain;">
                    @else
                        <i class="bi bi-mortarboard-fill"></i>
                    @endif
                </div>
                <div>
                    <h5 class="fw-bold text-white mb-0 lh-1">
                        Pro<span style="color: #c99738;">Teachers</span>
                    </h5>
                    <span class="mast-tag">
                        {{ $locale === 'tk' ? 'Türkmenistanyň ýokary bilim we mugallymlar binýady' : ($locale === 'ru' ? 'Единая образовательная платформа преподавателей Туркменистана' : 'Verified Academic Directory of Educators & University Professors') }}
                    </span>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3 mt-md-0">
                @if($setting?->instagram)
                    <a href="{{ $setting->instagram }}" target="_blank" class="social-circle" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                @endif
                @if($setting?->tiktok)
                    <a href="{{ $setting->tiktok }}" target="_blank" class="social-circle" title="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                @endif
                @if($setting?->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $setting->whatsapp) }}" target="_blank" class="social-circle" title="WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                @endif
                @if($setting?->imo)
                    <a href="tel:{{ $setting->imo }}" class="social-circle" title="IMO">
                        <i class="bi bi-chat-fill"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="row g-4 justify-content-between py-4">
            <div class="col-lg-4 col-md-6 pe-lg-4">
                <h6 class="footer-title">{{ $locale === 'tk' ? 'Platforma barada' : ($locale === 'ru' ? 'О платформе' : 'About Platform') }}</h6>
                <p class="footer-about-text">
                    {{ $locale === 'tk'
                        ? 'Ýurdumyzyň ýokary okuw mekdepleriniň professor-mugallymlaryny, talyplaryny we bilim merkezlerini birleşdirýän, elektron okuw gollanmalaryny we leksiýalary paýlaşmaga mümkinçilik berýän döwrebap maglumat ulgamy.'
                        : ($locale === 'ru'
                            ? 'Современная цифровая платформа, объединяющая профессорско-преподавательский состав вузов страны со студентами для обмена опытом и авторскими материалами.'
                            : 'An online educational network connecting university professors and students with verified academic profiles and downloadable learning materials.')
                    }}
                </p>
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill" style="background: rgba(201, 151, 56, 0.12); border: 1px solid rgba(201, 151, 56, 0.25);">
                    <i class="bi bi-shield-check" style="color: #c99738;"></i>
                    <span style="font-size: 0.75rem; color: #e4c478; font-weight: 700;">Döwlet Bilim Standarty</span>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <h6 class="footer-title">{{ $locale === 'tk' ? 'Bölümler' : ($locale === 'ru' ? 'Разделы' : 'Navigation') }}</h6>
                <ul class="footer-nav-list">
                    <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right"></i> {{ $locale === 'tk' ? 'Baş sahypa' : ($locale === 'ru' ? 'Главная' : 'Home') }}</a></li>
                    <li><a href="{{ route('teachers.index') }}"><i class="bi bi-chevron-right"></i> {{ $locale === 'tk' ? 'Mugallymlar' : ($locale === 'ru' ? 'Преподаватели' : 'Teachers') }}</a></li>
                    <li><a href="{{ route('documents.index') }}"><i class="bi bi-chevron-right"></i> {{ $locale === 'tk' ? 'Materiallar' : ($locale === 'ru' ? 'Материалы' : 'Documents') }}</a></li>
                    <li><a href="{{ route('chat.index') }}"><i class="bi bi-chevron-right"></i> {{ $locale === 'tk' ? 'Çatlar' : ($locale === 'ru' ? 'Чаты' : 'Direct Messages') }}</a></li>
                    <li><a href="{{ route('login') }}"><i class="bi bi-chevron-right"></i> {{ $locale === 'tk' ? 'Ulgama girmek' : ($locale === 'ru' ? 'Вход' : 'Sign In') }}</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-6">
                <h6 class="footer-title">{{ $locale === 'tk' ? 'Ders ugurlary' : ($locale === 'ru' ? 'Дисциплины' : 'Popular Subjects') }}</h6>
                <ul class="footer-nav-list">
                    @foreach($popularLessons as $lesson)
                        <li>
                            <a href="{{ route('teachers.index', ['lesson_id' => $lesson->id]) }}">
                                <i class="bi bi-chevron-right"></i> {{ $lesson->{'name_' . $locale} }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="footer-title">{{ $locale === 'tk' ? 'Habarlaşmak' : ($locale === 'ru' ? 'Контакты' : 'Contact Us') }}</h6>
                <ul class="footer-contacts-list">
                    @if($setting?->{'address_' . $locale})
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt-fill contact-icon mt-1"></i>
                            <span>{{ $setting->{'address_' . $locale} }}</span>
                        </li>
                    @endif
                    @if($setting?->phone_1)
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-telephone-fill contact-icon"></i>
                            <a href="tel:{{ $setting->phone_1 }}">{{ $setting->phone_1 }}</a>
                        </li>
                    @endif
                    @if($setting?->phone_2)
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-telephone-fill contact-icon"></i>
                            <a href="tel:{{ $setting->phone_2 }}">{{ $setting->phone_2 }}</a>
                        </li>
                    @endif
                    @if($setting?->email)
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope-fill contact-icon"></i>
                            <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="footer-bottom-base">
            <div class="d-flex align-items-center gap-2">
                <span>&copy; {{ date('Y') }} <strong class="text-white">{{ $siteName }}</strong>.</span>
                <span>{{ $locale === 'tk' ? 'Ähli hukuklar goralan.' : ($locale === 'ru' ? 'Все права защищены.' : 'All rights reserved.') }}</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                <nav class="footer-lang-nav">
                    <a href="{{ route('locale.switch', 'tk') }}" class="{{ $locale === 'tk' ? 'active' : '' }}">TM</a>
                    <span class="sep">&bull;</span>
                    <a href="{{ route('locale.switch', 'ru') }}" class="{{ $locale === 'ru' ? 'active' : '' }}">RU</a>
                    <span class="sep">&bull;</span>
                    <a href="{{ route('locale.switch', 'en') }}" class="{{ $locale === 'en' ? 'active' : '' }}">EN</a>
                </nav>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-academic {
        background-color: #071511;
        color: #8fa59e;
        border-top: 3px solid #c99738;
        font-size: 0.86rem;
    }

    .footer-top-mast {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding: 24px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .mast-emblem {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: rgba(201, 151, 56, 0.15);
        color: #c99738;
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(201, 151, 56, 0.3);
    }

    .mast-tag {
        font-size: 0.72rem;
        color: #9ab4ac;
        display: block;
        margin-top: 3px;
    }

    .social-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.12);
        transition: all 0.2s ease;
    }

    .social-circle:hover {
        background: #106248;
        border-color: #106248;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .footer-title {
        color: #ffffff;
        font-size: 0.78rem;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: 0.08em;
        margin-bottom: 16px;
    }

    .footer-about-text {
        font-size: 0.83rem;
        color: #8fa59e;
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .footer-nav-list, .footer-contacts-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .footer-nav-list a {
        color: #8fa59e;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .footer-nav-list a i {
        font-size: 0.65rem;
        color: #c99738;
        transition: transform 0.15s ease;
    }

    .footer-nav-list a:hover {
        color: #ffffff;
        transform: translateX(3px);
    }

    .footer-contacts-list a {
        color: #8fa59e;
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .footer-contacts-list a:hover {
        color: #ffffff;
    }

    .contact-icon {
        color: #c99738;
        font-size: 0.85rem;
    }

    .footer-bottom-base {
        padding: 20px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 0.78rem;
        color: #6c847c;
    }

    .footer-lang-nav {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .footer-lang-nav a {
        color: #8fa59e;
        text-decoration: none;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 700;
    }

    .footer-lang-nav a.active, .footer-lang-nav a:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.12);
    }

    .footer-lang-nav .sep {
        opacity: 0.3;
    }
</style>