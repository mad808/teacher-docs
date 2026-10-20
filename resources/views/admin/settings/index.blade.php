@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Saýt sazlamalary',
            'ru' => 'Настройки сайта',
            'en' => 'Site Settings',
        ],
        'site_info' => [
            'tk' => 'Saýtyň atlary',
            'ru' => 'Названия сайта',
            'en' => 'Site Names',
        ],
        'contact_info' => [
            'tk' => 'Habarlaşmak üçin maglumatlar',
            'ru' => 'Контактная информация',
            'en' => 'Contact Information',
        ],
        'addresses' => [
            'tk' => 'Salgylar',
            'ru' => 'Адреса',
            'en' => 'Addresses',
        ],
        'social_links' => [
            'tk' => 'Sosial torlar we aragatnaşyk',
            'ru' => 'Социальные сети и мессенджеры',
            'en' => 'Social Media & Messengers',
        ],
        'branding' => [
            'tk' => 'Logo we favicon',
            'ru' => 'Логотип и фавикон',
            'en' => 'Branding & Assets',
        ],
        'site_name_tk' => [
            'tk' => 'Saýtyň ady (Türkmençe)',
            'ru' => 'Название сайта (Туркменский)',
            'en' => 'Site Name (Turkmen)',
        ],
        'site_name_ru' => [
            'tk' => 'Saýtyň ady (Rusça)',
            'ru' => 'Название сайта (Русский)',
            'en' => 'Site Name (Russian)',
        ],
        'site_name_en' => [
            'tk' => 'Saýtyň ady (Iňlisçe)',
            'ru' => 'Название сайта (Английский)',
            'en' => 'Site Name (English)',
        ],
        'phone_1' => [
            'tk' => 'Telefon belgisi 1',
            'ru' => 'Телефон 1',
            'en' => 'Primary Phone',
        ],
        'phone_2' => [
            'tk' => 'Telefon belgisi 2',
            'ru' => 'Телефон 2',
            'en' => 'Secondary Phone',
        ],
        'email' => [
            'tk' => 'E-poçta salgysy',
            'ru' => 'Электронная почта',
            'en' => 'Email Address',
        ],
        'address_tk' => [
            'tk' => 'Salgy (Türkmençe)',
            'ru' => 'Адрес (Туркменский)',
            'en' => 'Address (Turkmen)',
        ],
        'address_ru' => [
            'tk' => 'Salgy (Rusça)',
            'ru' => 'Адрес (Русский)',
            'en' => 'Address (Russian)',
        ],
        'address_en' => [
            'tk' => 'Salgy (Iňlisçe)',
            'ru' => 'Адрес (Английский)',
            'en' => 'Address (English)',
        ],
        'logo' => [
            'tk' => 'Saýtyň logotipi',
            'ru' => 'Логотип сайта',
            'en' => 'Site Logo',
        ],
        'favicon' => [
            'tk' => 'Favicon nyşany',
            'ru' => 'Фавикон (Favicon)',
            'en' => 'Site Favicon',
        ],
        'save_btn' => [
            'tk' => 'Sazlamalary ýatda sakla',
            'ru' => 'Сохранить настройки',
            'en' => 'Save Settings',
        ],
        'current_file' => [
            'tk' => 'Häzirki:',
            'ru' => 'Текущий:',
            'en' => 'Current:',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])
@section('page_title', $texts['page_title'][$locale])

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">{{ $texts['page_title'][$locale] }}</h4>
            <p class="text-muted small mb-0">Platformanyň umumy maglumatlaryny dolandyryň</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-fonts text-primary me-2"></i>{{ $texts['site_info'][$locale] }}
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-dark">{{ $texts['site_name_tk'][$locale] }} <span class="text-danger">*</span></label>
                            <input type="text" name="site_name_tk" class="form-control" value="{{ old('site_name_tk', $setting->site_name_tk) }}" required>
                            @error('site_name_tk')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-dark">{{ $texts['site_name_ru'][$locale] }} <span class="text-danger">*</span></label>
                            <input type="text" name="site_name_ru" class="form-control" value="{{ old('site_name_ru', $setting->site_name_ru) }}" required>
                            @error('site_name_ru')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-dark">{{ $texts['site_name_en'][$locale] }} <span class="text-danger">*</span></label>
                            <input type="text" name="site_name_en" class="form-control" value="{{ old('site_name_en', $setting->site_name_en) }}" required>
                            @error('site_name_en')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-geo-alt text-primary me-2"></i>{{ $texts['addresses'][$locale] }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['address_tk'][$locale] }}</label>
                        <input type="text" name="address_tk" class="form-control" value="{{ old('address_tk', $setting->address_tk) }}" placeholder="Aşgabat ş., Magtymguly şaýoly 12">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['address_ru'][$locale] }}</label>
                        <input type="text" name="address_ru" class="form-control" value="{{ old('address_ru', $setting->address_ru) }}" placeholder="г. Ашхабад, проспект Махтумкули 12">
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-dark">{{ $texts['address_en'][$locale] }}</label>
                        <input type="text" name="address_en" class="form-control" value="{{ old('address_en', $setting->address_en) }}" placeholder="Ashgabat, Magtymguly avenue 12">
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-share text-primary me-2"></i>{{ $texts['social_links'][$locale] }}
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">
                                <i class="bi bi-instagram text-danger me-1"></i> Instagram URL
                            </label>
                            <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $setting->instagram) }}" placeholder="https://instagram.com/proteachers">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">
                                <i class="bi bi-tiktok text-dark me-1"></i> TikTok URL
                            </label>
                            <input type="text" name="tiktok" class="form-control" value="{{ old('tiktok', $setting->tiktok) }}" placeholder="https://tiktok.com/@proteachers">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">
                                <i class="bi bi-whatsapp text-success me-1"></i> WhatsApp
                            </label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $setting->whatsapp) }}" placeholder="+99365123456">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">
                                <i class="bi bi-chat-fill text-primary me-1"></i> IMO
                            </label>
                            <input type="text" name="imo" class="form-control" value="{{ old('imo', $setting->imo) }}" placeholder="+99365123456">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-telephone text-primary me-2"></i>{{ $texts['contact_info'][$locale] }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['phone_1'][$locale] }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="phone_1" class="form-control" value="{{ old('phone_1', $setting->phone_1) }}" placeholder="+993 12 000000">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['phone_2'][$locale] }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="phone_2" class="form-control" value="{{ old('phone_2', $setting->phone_2) }}" placeholder="+993 65 000000">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-dark">{{ $texts['email'][$locale] }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $setting->email) }}" placeholder="info@proteachers.edu">
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-palette text-primary me-2"></i>{{ $texts['branding'][$locale] }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['logo'][$locale] }}</label>
                        @if($setting->logo)
                            <div class="mb-2 p-2 bg-light rounded-3 text-center border">
                                <img src="{{ asset('storage/' . $setting->logo) }}" height="40" alt="Logo">
                            </div>
                        @endif
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        @error('logo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-dark">{{ $texts['favicon'][$locale] }}</label>
                        @if($setting->favicon)
                            <div class="mb-2 p-2 bg-light rounded-3 text-center border">
                                <img src="{{ asset('storage/' . $setting->favicon) }}" width="24" height="24" alt="Favicon">
                            </div>
                        @endif
                        <input type="file" name="favicon" class="form-control" accept=".ico,.png,.jpg,.svg">
                        @error('favicon')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">
                    <i class="bi bi-check2-circle me-1"></i> {{ $texts['save_btn'][$locale] }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection