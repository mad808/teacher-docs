@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Täze talyp goşmak',
            'ru' => 'Добавить студента / пользователя',
            'en' => 'Add New Student',
        ],
        'back' => [
            'tk' => 'Yza dolan',
            'ru' => 'Назад',
            'en' => 'Back',
        ],
        'main_info' => [
            'tk' => 'Esasy maglumatlar',
            'ru' => 'Основные данные',
            'en' => 'Main Information',
        ],
        'name' => [
            'tk' => 'Doly ady',
            'ru' => 'ФИО / Имя',
            'en' => 'Full Name',
        ],
        'phone' => [
            'tk' => 'Telefon belgisi',
            'ru' => 'Номер телефона',
            'en' => 'Phone Number',
        ],
        'email' => [
            'tk' => 'E-poçta salgysy',
            'ru' => 'Электронная почта',
            'en' => 'Email Address',
        ],
        'password' => [
            'tk' => 'Açar sözi',
            'ru' => 'Пароль',
            'en' => 'Password',
        ],
        'avatar' => [
            'tk' => 'Suraty (Avatar)',
            'ru' => 'Фотография (Аватар)',
            'en' => 'Photo (Avatar)',
        ],
        'save_btn' => [
            'tk' => 'Ýatda sakla',
            'ru' => 'Сохранить',
            'en' => 'Save Student',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])
@section('page_title', $texts['page_title'][$locale])

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0 text-dark">{{ $texts['page_title'][$locale] }}</h4>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> {{ $texts['back'][$locale] }}
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-person-fill text-primary me-2"></i>{{ $texts['main_info'][$locale] }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Meselem: Aman Amanow" required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">{{ $texts['phone'][$locale] }} <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+99365000000" required>
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">{{ $texts['email'][$locale] }}</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="aman@proteachers.edu">
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['password'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Iň az 6 sany simwol" required>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">{{ $texts['avatar'][$locale] }}</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                        @error('avatar')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('admin.students.index') }}" class="btn btn-light rounded-pill px-4">
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