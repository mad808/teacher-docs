@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Mugallymlar',
            'ru' => 'Преподаватели',
            'en' => 'Teachers',
        ],
        'add_new' => [
            'tk' => 'Täze mugallym goş',
            'ru' => 'Добавить преподавателя',
            'en' => 'Add Teacher',
        ],
        'search_placeholder' => [
            'tk' => 'Ady ýa-da telefon belgisi boýunça...',
            'ru' => 'Поиск по имени или телефону...',
            'en' => 'Search by name or phone...',
        ],
        'filter_institution' => [
            'tk' => 'Ähli okuw jaýlary',
            'ru' => 'Все учебные заведения',
            'en' => 'All institutions',
        ],
        'filter_btn' => [
            'tk' => 'Gözle',
            'ru' => 'Поиск',
            'en' => 'Filter',
        ],
        'teacher' => [
            'tk' => 'Mugallym',
            'ru' => 'Преподаватель',
            'en' => 'Teacher',
        ],
        'institution_dept' => [
            'tk' => 'Okuw jaýy we kafedrasy',
            'ru' => 'Учреждение и кафедра',
            'en' => 'Institution & Department',
        ],
        'title_degree' => [
            'tk' => 'Wezipesi we derejesi',
            'ru' => 'Должность и степень',
            'en' => 'Title & Degree',
        ],
        'experience' => [
            'tk' => 'Tejribe',
            'ru' => 'Опыт',
            'en' => 'Experience',
        ],
        'lessons' => [
            'tk' => 'Dersleri',
            'ru' => 'Предметы',
            'en' => 'Subjects',
        ],
        'verified' => [
            'tk' => 'Tassyklanan',
            'ru' => 'Подтвержден',
            'en' => 'Verified',
        ],
        'unverified' => [
            'tk' => 'Tassyklanmadyk',
            'ru' => 'Не подтвержден',
            'en' => 'Unverified',
        ],
        'actions' => [
            'tk' => 'Hereketler',
            'ru' => 'Действия',
            'en' => 'Actions',
        ],
        'edit' => [
            'tk' => 'Üýtget',
            'ru' => 'Редактировать',
            'en' => 'Edit',
        ],
        'delete' => [
            'tk' => 'Poz',
            'ru' => 'Удалить',
            'en' => 'Delete',
        ],
        'delete_confirm' => [
            'tk' => 'Bu mugallymy, onuň profilini we resminamalaryny doly pozmak isleýärsiňizmi?',
            'ru' => 'Удалить преподавателя, профиль и все материалы?',
            'en' => 'Delete this teacher, profile, and all associated documents?',
        ],
        'empty' => [
            'tk' => 'Hiç hili mugallym tapylmady.',
            'ru' => 'Преподаватели не найдены.',
            'en' => 'No teachers found.',
        ],
        'years' => [
            'tk' => 'ýyl',
            'ru' => 'лет',
            'en' => 'yrs',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])
@section('page_title', $texts['page_title'][$locale])

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">{{ $texts['page_title'][$locale] }}</h4>
            <p class="text-muted small mb-0">{{ $teachers->total() }} {{ strtolower($texts['page_title'][$locale]) }}</p>
        </div>

        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary rounded-pill px-3 py-2 fw-semibold shadow-sm">
            <i class="bi bi-person-plus me-1"></i> {{ $texts['add_new'][$locale] }}
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.teachers.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-6 col-lg-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="{{ $texts['search_placeholder'][$locale] }}" value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <select name="institution_id" class="form-select select2">
                        <option value="">-- {{ $texts['filter_institution'][$locale] }} --</option>
                        @foreach($institutions as $inst)
                            <option value="{{ $inst->id }}" {{ request('institution_id') == $inst->id ? 'selected' : '' }}>
                                {{ $inst->{'name_' . $locale} }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3">
                        {{ $texts['filter_btn'][$locale] }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">{{ $texts['teacher'][$locale] }}</th>
                        <th>{{ $texts['institution_dept'][$locale] }}</th>
                        <th>{{ $texts['title_degree'][$locale] }}</th>
                        <th class="text-center">{{ $texts['experience'][$locale] }}</th>
                        <th>{{ $texts['lessons'][$locale] }}</th>
                        <th>Status</th>
                        <th class="text-end pe-4">{{ $texts['actions'][$locale] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    @if($teacher->user->avatar)
                                        <img src="{{ asset('storage/' . $teacher->user->avatar) }}" class="rounded-circle object-fit-cover shadow-xs border" width="44" height="44" alt="">
                                    @else
                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 44px; height: 44px;">
                                            {{ strtoupper(substr($teacher->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark">{{ $teacher->user->name }}</div>
                                        <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $teacher->user->phone }}</small>
                                        @if($teacher->rating > 0)
                                            <div class="small text-warning">
                                                <i class="bi bi-star-fill"></i>
                                                <span class="text-dark fw-bold ms-1">{{ number_format($teacher->rating, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="fw-semibold text-dark small">{{ $teacher->institution?->{'name_' . $locale} ?? '—' }}</div>
                                <small class="text-muted d-block">{{ $teacher->department?->{'name_' . $locale} ?? '—' }}</small>
                            </td>

                            <td>
                                <div class="small fw-semibold text-dark">{{ $teacher->{'title_' . $locale} ?: '—' }}</div>
                                <small class="text-muted d-block">{{ $teacher->{'degree_' . $locale} ?: '—' }}</small>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1 fw-semibold">
                                    {{ $teacher->experience_years }} {{ $texts['years'][$locale] }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex flex-wrap gap-1" style="max-width: 220px;">
                                    @forelse($teacher->lessons as $lesson)
                                        <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.7rem;">
                                            {{ $lesson->{'name_' . $locale} }}
                                        </span>
                                    @empty
                                        <span class="text-muted small">—</span>
                                    @endforelse
                                </div>
                            </td>

                            <td>
                                @if($teacher->is_verified)
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">
                                        <i class="bi bi-patch-check-fill me-1"></i>{{ $texts['verified'][$locale] }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1">
                                        {{ $texts['unverified'][$locale] }}
                                    </span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('teachers.show', $teacher->id) }}" target="_blank" class="btn btn-sm btn-light border rounded-pill px-2" title="Gör">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>

                                    <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-sm btn-light border rounded-pill px-3" title="{{ $texts['edit'][$locale] }}">
                                        <i class="bi bi-pencil me-1"></i> {{ $texts['edit'][$locale] }}
                                    </a>

                                    <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('{{ $texts['delete_confirm'][$locale] }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="{{ $texts['delete'][$locale] }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                {{ $texts['empty'][$locale] }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($teachers->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $teachers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection