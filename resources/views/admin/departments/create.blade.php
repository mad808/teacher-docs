@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Täze bölüm goşmak',
            'ru' => 'Добавить кафедру / факультет',
            'en' => 'Add New Department',
        ],
        'back' => [
            'tk' => 'Yza dolan',
            'ru' => 'Назад',
            'en' => 'Back',
        ],
        'institution_select' => [
            'tk' => 'Baglanyşykly okuw jaýy',
            'ru' => 'Учебное заведение',
            'en' => 'Affiliated Institution',
        ],
        'select_placeholder' => [
            'tk' => 'Okuw jaýyny saýlaň',
            'ru' => 'Выберите учебное заведение',
            'en' => 'Select an institution',
        ],
        'name_tk' => [
            'tk' => 'Bölümiň ady (Türkmençe)',
            'ru' => 'Название кафедры (Туркменский)',
            'en' => 'Department Name (Turkmen)',
        ],
        'name_ru' => [
            'tk' => 'Bölümiň ady (Rusça)',
            'ru' => 'Название кафедры (Русский)',
            'en' => 'Department Name (Russian)',
        ],
        'name_en' => [
            'tk' => 'Bölümiň ady (Iňlisçe)',
            'ru' => 'Название кафедры (Английский)',
            'en' => 'Department Name (English)',
        ],
        'status' => [
            'tk' => 'Işjeňlik ýagdaýy',
            'ru' => 'Активный статус',
            'en' => 'Active Status',
        ],
        'save_btn' => [
            'tk' => 'Ýatda sakla',
            'ru' => 'Сохранить',
            'en' => 'Save Department',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])
@section('page_title', $texts['page_title'][$locale])

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0 text-dark">{{ $texts['page_title'][$locale] }}</h4>
        <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> {{ $texts['back'][$locale] }}
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <form action="{{ route('admin.departments.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">{{ $texts['institution_select'][$locale] }} <span class="text-danger">*</span></label>
                        <select name="institution_id" class="form-select select2" required>
                            <option value="">-- {{ $texts['select_placeholder'][$locale] }} --</option>
                            @foreach($institutions as $inst)
                                <option value="{{ $inst->id }}" {{ old('institution_id') == $inst->id ? 'selected' : '' }}>
                                    {{ $inst->{'name_' . $locale} }} ({{ $inst->city ?? '—' }})
                                </option>
                            @endforeach
                        </select>
                        @error('institution_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name_tk'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name_tk" class="form-control" value="{{ old('name_tk') }}" placeholder="Meselem: Maglumat tehnologiýalary kafedrasy" required>
                        @error('name_tk')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name_ru'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name_ru" class="form-control" value="{{ old('name_ru') }}" placeholder="Например: Кафедра информационных технологий" required>
                        @error('name_ru')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name_en'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" placeholder="E.g.: Department of Information Technology" required>
                        @error('name_en')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="statusSwitch" checked>
                        <label class="form-check-label small fw-semibold text-dark" for="statusSwitch">
                            {{ $texts['status'][$locale] }}
                        </label>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('admin.departments.index') }}" class="btn btn-light rounded-pill px-4">
                            {{ $texts['back'][$locale] }}
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> {{ $texts['save_btn'][$locale] }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection