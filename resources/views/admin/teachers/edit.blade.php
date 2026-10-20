@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Mugallym maglumatyny üýtgetmek',
            'ru' => 'Редактировать преподавателя',
            'en' => 'Edit Teacher',
        ],
        'back' => [
            'tk' => 'Yza dolan',
            'ru' => 'Назад',
            'en' => 'Back',
        ],
        'account_info' => [
            'tk' => 'Ulanyjy hasap maglumaty',
            'ru' => 'Учетная запись',
            'en' => 'User Account Info',
        ],
        'academic_info' => [
            'tk' => 'Okuw we ylmy maglumatlar',
            'ru' => 'Академические данные',
            'en' => 'Academic Information',
        ],
        'multilang_info' => [
            'tk' => 'Diller boýunça maglumatlar',
            'ru' => 'Многоязычная информация',
            'en' => 'Multilingual Details',
        ],
        'name' => [
            'tk' => 'Doly ady',
            'ru' => 'ФИО преподавателя',
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
            'tk' => 'Täze açar sözi (üýtgetmejek bolsaňyz boş goýuň)',
            'ru' => 'Новый пароль (оставьте пустым, если не меняете)',
            'en' => 'New Password (leave blank to keep current)',
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
        'institution' => [
            'tk' => 'Okuw jaýy',
            'ru' => 'Учебное заведение',
            'en' => 'Institution',
        ],
        'department' => [
            'tk' => 'Bölümi / Kafedrasy',
            'ru' => 'Кафедра / факультет',
            'en' => 'Department',
        ],
        'lessons' => [
            'tk' => 'Berýän dersleri',
            'ru' => 'Преподаваемые предметы',
            'en' => 'Assigned Subjects',
        ],
        'experience' => [
            'tk' => 'Iş tejribesi (ýyl)',
            'ru' => 'Стаж работы (лет)',
            'en' => 'Experience (years)',
        ],
        'verified' => [
            'tk' => 'Tassyklanan mugallym statusy',
            'ru' => 'Статус подтвержденного профиля',
            'en' => 'Verified Profile Status',
        ],
        'title' => [
            'tk' => 'Wezipesi',
            'ru' => 'Должность',
            'en' => 'Title',
        ],
        'degree' => [
            'tk' => 'Ylmy derejesi',
            'ru' => 'Ученая степень',
            'en' => 'Academic Degree',
        ],
        'education_center' => [
            'tk' => 'Goşmaça bilim / okuw merkezi',
            'ru' => 'Образовательный центр',
            'en' => 'Education Center',
        ],
        'bio' => [
            'tk' => 'Mugallym barada giňişleýin maglumat (Biografiýa)',
            'ru' => 'Подробная биография и описание',
            'en' => 'Detailed Biography',
        ],
        'update_btn' => [
            'tk' => 'Täzele',
            'ru' => 'Обновить',
            'en' => 'Update Teacher',
        ],
    ];

    $assignedLessons = old('lessons', $teacher->lessons->pluck('id')->toArray());
@endphp

@section('title', $texts['page_title'][$locale])
@section('page_title', $texts['page_title'][$locale])

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0 text-dark">{{ $texts['page_title'][$locale] }}</h4>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> {{ $texts['back'][$locale] }}
        </a>
    </div>

    <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-person-circle text-primary me-2"></i>{{ $texts['account_info'][$locale] }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['name'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->user->name) }}" required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">{{ $texts['phone'][$locale] }} <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->user->phone) }}" required>
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">{{ $texts['email'][$locale] }}</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->user->email) }}">
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

                    @if($teacher->user->avatar)
                        <div class="mb-3 d-flex align-items-center gap-3">
                            <span class="small text-muted">{{ $texts['current_avatar'][$locale] }}</span>
                            <img src="{{ asset('storage/' . $teacher->user->avatar) }}" class="rounded-circle object-fit-cover border" width="48" height="48" alt="">
                        </div>
                    @endif

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-dark">{{ $texts['avatar'][$locale] }}</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                        @error('avatar')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-translate text-primary me-2"></i>{{ $texts['multilang_info'][$locale] }}
                    </h6>

                    <ul class="nav nav-pills mb-3 gap-2" id="langTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active rounded-pill px-3 py-1 small" id="tk-tab" data-bs-toggle="tab" data-bs-target="#tab-tk" type="button">Türkmençe</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill px-3 py-1 small" id="ru-tab" data-bs-toggle="tab" data-bs-target="#tab-ru" type="button">Русский</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill px-3 py-1 small" id="en-tab" data-bs-toggle="tab" data-bs-target="#tab-en" type="button">English</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="langTabsContent">
                        <div class="tab-pane fade show active" id="tab-tk">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">{{ $texts['title'][$locale] }} (TK)</label>
                                <input type="text" name="title_tk" class="form-control" value="{{ old('title_tk', $teacher->title_tk) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">{{ $texts['degree'][$locale] }} (TK)</label>
                                <input type="text" name="degree_tk" class="form-control" value="{{ old('degree_tk', $teacher->degree_tk) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">{{ $texts['education_center'][$locale] }} (TK)</label>
                                <input type="text" name="education_center_tk" class="form-control" value="{{ old('education_center_tk', $teacher->education_center_tk) }}">
                            </div>

                            <div class="mb-0">
                                <label class="form-label small fw-bold text-dark">{{ $texts['bio'][$locale] }} (TK)</label>
                                <textarea name="bio_tk" rows="4" class="form-control">{{ old('bio_tk', $teacher->bio_tk) }}</textarea>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-ru">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">{{ $texts['title'][$locale] }} (RU)</label>
                                <input type="text" name="title_ru" class="form-control" value="{{ old('title_ru', $teacher->title_ru) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">{{ $texts['degree'][$locale] }} (RU)</label>
                                <input type="text" name="degree_ru" class="form-control" value="{{ old('degree_ru', $teacher->degree_ru) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">{{ $texts['education_center'][$locale] }} (RU)</label>
                                <input type="text" name="education_center_ru" class="form-control" value="{{ old('education_center_ru', $teacher->education_center_ru) }}">
                            </div>

                            <div class="mb-0">
                                <label class="form-label small fw-bold text-dark">{{ $texts['bio'][$locale] }} (RU)</label>
                                <textarea name="bio_ru" rows="4" class="form-control">{{ old('bio_ru', $teacher->bio_ru) }}</textarea>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-en">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">{{ $texts['title'][$locale] }} (EN)</label>
                                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $teacher->title_en) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">{{ $texts['degree'][$locale] }} (EN)</label>
                                <input type="text" name="degree_en" class="form-control" value="{{ old('degree_en', $teacher->degree_en) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">{{ $texts['education_center'][$locale] }} (EN)</label>
                                <input type="text" name="education_center_en" class="form-control" value="{{ old('education_center_en', $teacher->education_center_en) }}">
                            </div>

                            <div class="mb-0">
                                <label class="form-label small fw-bold text-dark">{{ $texts['bio'][$locale] }} (EN)</label>
                                <textarea name="bio_en" rows="4" class="form-control">{{ old('bio_en', $teacher->bio_en) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-mortarboard-fill text-primary me-2"></i>{{ $texts['academic_info'][$locale] }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['institution'][$locale] }}</label>
                        <select name="institution_id" id="institution_select" class="form-select select2">
                            <option value="">-- Saýlaň --</option>
                            @foreach($institutions as $inst)
                                <option value="{{ $inst->id }}" {{ old('institution_id', $teacher->institution_id) == $inst->id ? 'selected' : '' }}>
                                    {{ $inst->{'name_' . $locale} }}
                                </option>
                            @endforeach
                        </select>
                        @error('institution_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['department'][$locale] }}</label>
                        <select name="department_id" id="department_select" class="form-select select2">
                            <option value="">-- Saýlaň --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id', $teacher->department_id) == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->{'name_' . $locale} }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['lessons'][$locale] }}</label>
                        <select name="lessons[]" class="form-select select2" multiple>
                            @foreach($lessons as $lesson)
                                <option value="{{ $lesson->id }}" {{ in_array($lesson->id, $assignedLessons) ? 'selected' : '' }}>
                                    {{ $lesson->{'name_' . $locale} }}
                                </option>
                            @endforeach
                        </select>
                        @error('lessons')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">{{ $texts['experience'][$locale] }} <span class="text-danger">*</span></label>
                        <input type="number" name="experience_years" class="form-control" value="{{ old('experience_years', $teacher->experience_years) }}" min="0" max="60" required>
                        @error('experience_years')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="is_verified" value="1" id="verifiedSwitch" {{ old('is_verified', $teacher->is_verified) ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark" for="verifiedSwitch">
                            {{ $texts['verified'][$locale] }}
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> {{ $texts['update_btn'][$locale] }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection