@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Dersi üýtgetmek',
            'ru' => 'Редактировать предмет',
            'en' => 'Edit Lesson',
        ],
        'back' => [
            'tk' => 'Yza dolan',
            'ru' => 'Назад',
            'en' => 'Back',
        ],
        'names_section' => [
            'tk' => 'Dersiň atlary',
            'ru' => 'Названия предмета',
            'en' => 'Lesson Titles',
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
        'icon' => [
            'tk' => 'Nyşan (Bootstrap Icon klassy)',
            'ru' => 'Иконка (Bootstrap Icon класс)',
            'en' => 'Icon (Bootstrap Icon class)',
        ],
        'status' => [
            'tk' => 'Işjeňlik ýagdaýy',
            'ru' => 'Активный статус',
            'en' => 'Active Status',
        ],
        'update_btn' => [
            'tk' => 'Täzele',
            'ru' => 'Обновить',
            'en' => 'Update Lesson',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])
@section('page_title', $texts['page_title'][$locale])

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0 text-dark">{{ $texts['page_title'][$locale] }}</h4>
        <a href="{{ route('admin.lessons.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> {{ $texts['back'][$locale] }}
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-translate text-primary me-2"></i>{{ $texts['names_section'][$locale] }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name_tk'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name_tk" class="form-control" value="{{ old('name_tk', $lesson->name_tk) }}" required>
                        @error('name_tk')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name_ru'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name_ru" class="form-control" value="{{ old('name_ru', $lesson->name_ru) }}" required>
                        @error('name_ru')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name_en'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $lesson->name_en) }}" required>
                        @error('name_en')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">{{ $texts['icon'][$locale] }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-primary" id="icon-preview">
                                <i class="bi {{ old('icon', $lesson->icon ?: 'bi-journal-bookmark') }}"></i>
                            </span>
                            <input type="text" name="icon" id="icon-input" class="form-control" value="{{ old('icon', $lesson->icon) }}" placeholder="bi-journal-bookmark">
                        </div>
                        <small class="text-muted mt-1 d-block">
                            Meselem: <code>bi-calculator</code>, <code>bi-laptop</code>, <code>bi-translate</code>, <code>bi-globe</code>, <code>bi-book</code>
                        </small>
                        @error('icon')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="statusSwitch" {{ old('status', $lesson->status) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark" for="statusSwitch">
                            {{ $texts['status'][$locale] }}
                        </label>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('admin.lessons.index') }}" class="btn btn-light rounded-pill px-4">
                            {{ $texts['back'][$locale] }}
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> {{ $texts['update_btn'][$locale] }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#icon-input').on('input', function() {
        const iconClass = $(this).val().trim() || 'bi-journal-bookmark';
        $('#icon-preview').html('<i class="bi ' + iconClass + '"></i>');
    });
</script>
@endsection