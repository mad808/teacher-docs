@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Talyp maglumatyny üýtgetmek',
            'ru' => 'Редактировать студента / пользователя',
            'en' => 'Edit Student',
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
            'tk' => 'Açar sözi (üýtgetmejek bolsaňyz boş goýuň)',
            'ru' => 'Пароль (оставьте пустым, если не меняете)',
            'en' => 'Password (leave blank to keep current)',
        ],
        'avatar' => [
            'tk' => 'Täze surat (Avatar)',
            'ru' => 'Новое фото (Аватар)',
            'en' => 'New Photo (Avatar)',
        ],
        'current_avatar' => [
            'tk' => 'Häzirki suraty:',
            'ru' => 'Текущее фото:',
            'en' => 'Current photo:',
        ],
        'status' => [
            'tk' => 'Hasap ýagdaýy',
            'ru' => 'Статус аккаунта',
            'en' => 'Account Status',
        ],
        'active' => [
            'tk' => 'Işjeň',
            'ru' => 'Активен',
            'en' => 'Active',
        ],
        'blocked' => [
            'tk' => 'Petiklenen',
            'ru' => 'Заблокирован',
            'en' => 'Blocked',
        ],
        'update_btn' => [
            'tk' => 'Täzele',
            'ru' => 'Обновить',
            'en' => 'Update Student',
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
                <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-person-fill text-primary me-2"></i>{{ $texts['main_info'][$locale] }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">{{ $texts['phone'][$locale] }} <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}" required>
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">{{ $texts['email'][$locale] }}</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}">
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['password'][$locale] }}</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••">
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($student->avatar)
                        <div class="mb-3 d-flex align-items-center gap-3">
                            <span class="small text-muted">{{ $texts['current_avatar'][$locale] }}</span>
                            <img src="{{ asset('storage/' . $student->avatar) }}" class="rounded-circle object-fit-cover border" width="48" height="48" alt="">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['avatar'][$locale] }}</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                        @error('avatar')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">{{ $texts['status'][$locale] }} <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="1" {{ old('status', $student->status) == 1 ? 'selected' : '' }}>{{ $texts['active'][$locale] }}</option>
                            <option value="0" {{ old('status', $student->status) == 0 ? 'selected' : '' }}>{{ $texts['blocked'][$locale] }}</option>
                        </select>
                        @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('admin.students.index') }}" class="btn btn-light rounded-pill px-4">
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