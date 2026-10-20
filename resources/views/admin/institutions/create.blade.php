@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Täze okuw jaýy goşmak',
            'ru' => 'Добавить учебное заведение',
            'en' => 'Add New Institution',
        ],
        'back' => [
            'tk' => 'Yza dolan',
            'ru' => 'Назад',
            'en' => 'Back',
        ],
        'names_section' => [
            'tk' => 'Okuw jaýynyň ady',
            'ru' => 'Название учреждения',
            'en' => 'Institution Name',
        ],
        'details_section' => [
            'tk' => 'Esasy maglumatlar',
            'ru' => 'Основные данные',
            'en' => 'Main Details',
        ],
        'addresses_section' => [
            'tk' => 'Salgysy',
            'ru' => 'Адрес',
            'en' => 'Addresses',
        ],
        'name_tk' => [
            'tk' => 'Ady (Türkmençe)',
            'ru' => 'Название (Туркменский)',
            'en' => 'Name (Turkmen)',
        ],
        'name_ru' => [
            'tk' => 'Ady (Rusça)',
            'ru' => 'Название (Русский)',
            'en' => 'Name (Russian)',
        ],
        'name_en' => [
            'tk' => 'Ady (Iňlisçe)',
            'ru' => 'Название (Английский)',
            'en' => 'Name (English)',
        ],
        'type' => [
            'tk' => 'Görnüşi',
            'ru' => 'Тип',
            'en' => 'Type',
        ],
        'city' => [
            'tk' => 'Şäher',
            'ru' => 'Город',
            'en' => 'City',
        ],
        'phone' => [
            'tk' => 'Telefon belgisi',
            'ru' => 'Телефон',
            'en' => 'Phone',
        ],
        'website' => [
            'tk' => 'Web sahypasy',
            'ru' => 'Веб-сайт',
            'en' => 'Website',
        ],
        'logo' => [
            'tk' => 'Logotip',
            'ru' => 'Логотип',
            'en' => 'Logo',
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
        'status' => [
            'tk' => 'Işjeňlik ýagdaýy',
            'ru' => 'Активный статус',
            'en' => 'Active Status',
        ],
        'save_btn' => [
            'tk' => 'Ýatda sakla',
            'ru' => 'Сохранить',
            'en' => 'Save Institution',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])
@section('page_title', $texts['page_title'][$locale])

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0 text-dark">{{ $texts['page_title'][$locale] }}</h4>
        <a href="{{ route('admin.institutions.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> {{ $texts['back'][$locale] }}
        </a>
    </div>

    <form action="{{ route('admin.institutions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-translate text-primary me-2"></i>{{ $texts['names_section'][$locale] }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name_tk'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name_tk" class="form-control" value="{{ old('name_tk') }}" placeholder="Meselem: Magtymguly adyndaky TDU" required>
                        @error('name_tk')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name_ru'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name_ru" class="form-control" value="{{ old('name_ru') }}" placeholder="Например: ТГУ имени Махтумкули" required>
                        @error('name_ru')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name_en'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" placeholder="E.g.: Magtymguly Turkmen State University" required>
                        @error('name_en')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-geo-alt text-primary me-2"></i>{{ $texts['addresses_section'][$locale] }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['address_tk'][$locale] }}</label>
                        <input type="text" name="address_tk" class="form-control" value="{{ old('address_tk') }}" placeholder="Aşgabat ş., Türkmenbaşy şaýoly 31">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['address_ru'][$locale] }}</label>
                        <input type="text" name="address_ru" class="form-control" value="{{ old('address_ru') }}" placeholder="г. Ашхабад, проспект Туркменбаши 31">
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-dark">{{ $texts['address_en'][$locale] }}</label>
                        <input type="text" name="address_en" class="form-control" value="{{ old('address_en') }}" placeholder="Ashgabat, Turkmenbashi avenue 31">
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-info-circle text-primary me-2"></i>{{ $texts['details_section'][$locale] }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['type'][$locale] }} <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="university" {{ old('type') == 'university' ? 'selected' : '' }}>University</option>
                            <option value="institute" {{ old('type') == 'institute' ? 'selected' : '' }}>Institute</option>
                            <option value="academy" {{ old('type') == 'academy' ? 'selected' : '' }}>Academy</option>
                            <option value="college" {{ old('type') == 'college' ? 'selected' : '' }}>College</option>
                            <option value="education_center" {{ old('type') == 'education_center' ? 'selected' : '' }}>Education Center</option>
                            <option value="school" {{ old('type') == 'school' ? 'selected' : '' }}>School</option>
                        </select>
                        @error('type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['city'][$locale] }}</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', 'Aşgabat') }}" placeholder="Aşgabat">
                        @error('city')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['phone'][$locale] }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+993 12 942000">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['website'][$locale] }}</label>
                        <input type="url" name="website" class="form-control" value="{{ old('website') }}" placeholder="https://tdu.edu.tm">
                        @error('website')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['logo'][$locale] }}</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        @error('logo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="statusSwitch" checked>
                        <label class="form-check-label small fw-semibold text-dark" for="statusSwitch">
                            {{ $texts['status'][$locale] }}
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                        <i class="bi bi-check2-circle me-1"></i> {{ $texts['save_btn'][$locale] }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection