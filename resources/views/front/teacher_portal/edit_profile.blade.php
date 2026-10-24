@extends('front.layouts.app')

@php
    $locale = app()->getLocale();
    $user = auth()->user();
    $selectedLessonIds = $profile->lessons->pluck('id')->toArray();
@endphp

@section('title', 'Mugallym Portaly - Profili Sazla')

@section('content')
<!-- Header Nav -->
<div class="bg-light border-bottom py-3 mb-4">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Profili Üýtgetmek</h5>
            <p class="text-muted small mb-0">Şahsy, akademiki we habarlaşmak maglumatlaryňyzy täzeläň.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('teacher.portal.dashboard') }}" class="btn btn-white border btn-sm rounded-pill px-3 py-2 fw-semibold text-dark shadow-xs">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            @if(Route::has('teachers.show'))
                <a href="{{ route('teachers.show', $profile->id) }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 fw-semibold">
                    <i class="bi bi-eye me-1"></i> Açyk profili gör
                </a>
            @endif
        </div>
    </div>
</div>

<div class="container pb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Ýalňyşlyklar ýüze çykdy:</strong>
            <ul class="mb-0 mt-2 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('teacher.portal.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Left Column: Personal & Academic Info -->
            <div class="col-lg-8">
                <!-- Basic Info Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center">
                        <i class="bi bi-person-badge-fill text-success me-2 fs-4"></i>Esasy Maglumatlar
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold small text-dark">Doly Adyňyz <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-semibold small text-dark">Iş tejribesi (Ýyl) <span class="text-danger">*</span></label>
                            <input type="number" name="experience_years" min="0" class="form-control rounded-3" value="{{ old('experience_years', $profile->experience_years) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Okuw jaýy (ÝOK/Orta)</label>
                            <select name="institution_id" id="institution_select" class="form-select rounded-3">
                                <option value="">— Saýlaň —</option>
                                @foreach($institutions as $inst)
                                    <option value="{{ $inst->id }}" @selected(old('institution_id', $profile->institution_id) == $inst->id)>
                                        {{ $inst->{'name_' . $locale} }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Kafedra</label>
                            <select name="department_id" id="department_select" class="form-select rounded-3">
                                <option value="">— Saýlaň —</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" data-institution="{{ $dept->institution_id }}" @selected(old('department_id', $profile->department_id) == $dept->id)>
                                        {{ $dept->{'name_' . $locale} }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Multilingual Bio & Titles Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center">
                        <i class="bi bi-translate text-success me-2 fs-4"></i>Köp Dilli Maglumatlar
                    </h5>

                    <!-- Language Pills -->
                    <ul class="nav nav-pills nav-fill mb-3 bg-light p-1 rounded-pill" id="profileLangTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill py-2 small fw-semibold" id="tk-tab" data-bs-toggle="pill" data-bs-target="#tab-tk" type="button" role="tab">Türkmençe</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill py-2 small fw-semibold" id="ru-tab" data-bs-toggle="pill" data-bs-target="#tab-ru" type="button" role="tab">Русский</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill py-2 small fw-semibold" id="en-tab" data-bs-toggle="pill" data-bs-target="#tab-en" type="button" role="tab">English</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2" id="profileLangTabContent">
                        <!-- TK -->
                        <div class="tab-pane fade show active" id="tab-tk" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Wezipesi (TM)</label>
                                    <input type="text" name="title_tk" class="form-control rounded-3" placeholder="Mysaly: Baş mugallym" value="{{ old('title_tk', $profile->title_tk) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Ylmy derejesi (TM)</label>
                                    <input type="text" name="degree_tk" class="form-control rounded-3" placeholder="Mysaly: Dosent, Ylymlaryň kandidaty" value="{{ old('degree_tk', $profile->degree_tk) }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-dark">Bilim / Ylmy merkezi (TM)</label>
                                    <input type="text" name="education_center_tk" class="form-control rounded-3" placeholder="Merkeziň ady" value="{{ old('education_center_tk', $profile->education_center_tk) }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-dark">Mugallym barada / Biografiýa (TM)</label>
                                    <textarea name="bio_tk" rows="4" class="form-control rounded-3" placeholder="Özüňiz, ylmy işleriňiz barada giňişleýin maglumat...">{{ old('bio_tk', $profile->bio_tk) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- RU -->
                        <div class="tab-pane fade" id="tab-ru" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Должность (RU)</label>
                                    <input type="text" name="title_ru" class="form-control rounded-3" placeholder="Пример: Старший преподаватель" value="{{ old('title_ru', $profile->title_ru) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Ученая степень (RU)</label>
                                    <input type="text" name="degree_ru" class="form-control rounded-3" placeholder="Пример: Доцент, Кандидат наук" value="{{ old('degree_ru', $profile->degree_ru) }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-dark">Учебный / Научный центр (RU)</label>
                                    <input type="text" name="education_center_ru" class="form-control rounded-3" placeholder="Название центра" value="{{ old('education_center_ru', $profile->education_center_ru) }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-dark">О преподавателе / Биография (RU)</label>
                                    <textarea name="bio_ru" rows="4" class="form-control rounded-3" placeholder="Подробная информация о вас...">{{ old('bio_ru', $profile->bio_ru) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- EN -->
                        <div class="tab-pane fade" id="tab-en" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Position / Title (EN)</label>
                                    <input type="text" name="title_en" class="form-control rounded-3" placeholder="Example: Senior Lecturer" value="{{ old('title_en', $profile->title_en) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Academic Degree (EN)</label>
                                    <input type="text" name="degree_en" class="form-control rounded-3" placeholder="Example: Associate Professor, Ph.D." value="{{ old('degree_en', $profile->degree_en) }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-dark">Education / Research Center (EN)</label>
                                    <input type="text" name="education_center_en" class="form-control rounded-3" placeholder="Center name" value="{{ old('education_center_en', $profile->education_center_en) }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-dark">About Teacher / Biography (EN)</label>
                                    <textarea name="bio_en" rows="4" class="form-control rounded-3" placeholder="Detailed biography and scientific interests...">{{ old('bio_en', $profile->bio_en) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lessons Selection Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center">
                        <i class="bi bi-book-half text-success me-2 fs-4"></i>Okadýan Dersleriňiz
                    </h5>
                    <p class="text-muted small mb-3">Profiliňizde görkezilmeli dersleri saýlaň:</p>

                    <div class="row g-2" style="max-height: 280px; overflow-y: auto;">
                        @foreach($lessons as $lesson)
                            <div class="col-md-6">
                                <div class="p-2 border rounded-3 bg-light d-flex align-items-center gap-2">
                                    <input class="form-check-input ms-1" type="checkbox" name="lessons[]" value="{{ $lesson->id }}" id="lesson_{{ $lesson->id }}" @checked(in_array($lesson->id, old('lessons', $selectedLessonIds)))>
                                    <label class="form-check-label small fw-semibold text-dark text-truncate w-100 cursor-pointer" for="lesson_{{ $lesson->id }}">
                                        <i class="bi {{ $lesson->icon ?: 'bi-book' }} text-success me-1"></i>
                                        {{ $lesson->{'name_' . $locale} }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Avatar & Action Buttons -->
            <div class="col-lg-4">
                <!-- Avatar Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4 text-center">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-3">Profil Suraty</h6>

                    <div class="position-relative d-inline-block mx-auto mb-3">
                        <img id="avatar-preview" 
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://placehold.co/140x140?text=' . substr($user->name, 0, 1) }}" 
                             class="rounded-circle object-fit-cover border border-4 border-white shadow-sm" 
                             width="130" height="130" 
                             alt="{{ $user->name }}">
                    </div>

                    <div class="mb-3">
                        <label for="avatar_input" class="btn btn-outline-success btn-sm rounded-pill px-3 py-2 fw-semibold w-100">
                            <i class="bi bi-camera me-1"></i> Täze surat saýlaň
                        </label>
                        <input type="file" id="avatar_input" name="avatar" class="d-none" accept="image/*" onchange="previewAvatar(event)">
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">JPG, PNG, WEBP (iň köp 2MB)</small>
                    </div>
                </div>

                <!-- Save Action Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center">
                    <button type="submit" class="btn btn-success btn-lg rounded-pill px-4 py-2 fw-semibold w-100 shadow-sm mb-2">
                        <i class="bi bi-check2-circle me-1"></i> Ýatda Sakla
                    </button>
                    <a href="{{ route('teacher.portal.dashboard') }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold w-100 border">
                        Ýatyr
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewAvatar(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection