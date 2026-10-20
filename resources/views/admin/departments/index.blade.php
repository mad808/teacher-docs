@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Kafedralar we bölümler',
            'ru' => 'Кафедры и факультеты',
            'en' => 'Departments & Faculties',
        ],
        'add_new' => [
            'tk' => 'Täze bölüm goş',
            'ru' => 'Добавить кафедру',
            'en' => 'Add Department',
        ],
        'filter_institution' => [
            'tk' => 'Okuw jaýy boýunça süzgüç',
            'ru' => 'Фильтр по институту',
            'en' => 'Filter by institution',
        ],
        'all_institutions' => [
            'tk' => 'Ähli okuw jaýlary',
            'ru' => 'Все учебные заведения',
            'en' => 'All institutions',
        ],
        'filter_btn' => [
            'tk' => 'Gözle',
            'ru' => 'Найти',
            'en' => 'Filter',
        ],
        'institution' => [
            'tk' => 'Okuw jaýy',
            'ru' => 'Учебное заведение',
            'en' => 'Institution',
        ],
        'department_name' => [
            'tk' => 'Bölümiň ady',
            'ru' => 'Название кафедры',
            'en' => 'Department Name',
        ],
        'teachers_count' => [
            'tk' => 'Mugallym sany',
            'ru' => 'Преподаватели',
            'en' => 'Teachers',
        ],
        'status' => [
            'tk' => 'Ýagdaýy',
            'ru' => 'Статус',
            'en' => 'Status',
        ],
        'actions' => [
            'tk' => 'Hereketler',
            'ru' => 'Действия',
            'en' => 'Actions',
        ],
        'active' => [
            'tk' => 'Işjeň',
            'ru' => 'Активен',
            'en' => 'Active',
        ],
        'inactive' => [
            'tk' => 'Işjeň däl',
            'ru' => 'Неактивен',
            'en' => 'Inactive',
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
            'tk' => 'Bu bölümi pozmak isleýärsiňizmi?',
            'ru' => 'Удалить эту кафедру?',
            'en' => 'Are you sure you want to delete this department?',
        ],
        'empty' => [
            'tk' => 'Hiç hili bölüm tapylmady.',
            'ru' => 'Кафедры не найдены.',
            'en' => 'No departments found.',
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
            <p class="text-muted small mb-0">{{ $departments->total() }} {{ strtolower($texts['page_title'][$locale]) }}</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.departments.create') }}" class="btn btn-primary rounded-pill px-3 py-2 fw-semibold shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> {{ $texts['add_new'][$locale] }}
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.departments.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-9 col-lg-10">
                    <select name="institution_id" class="form-select select2">
                        <option value="">-- {{ $texts['all_institutions'][$locale] }} --</option>
                        @foreach($institutions as $inst)
                            <option value="{{ $inst->id }}" {{ request('institution_id') == $inst->id ? 'selected' : '' }}>
                                {{ $inst->{'name_' . $locale} }} ({{ $inst->city ?? '—' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-lg-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3">
                        <i class="bi bi-filter me-1"></i> {{ $texts['filter_btn'][$locale] }}
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
                        <th class="ps-4">{{ $texts['department_name'][$locale] }}</th>
                        <th>{{ $texts['institution'][$locale] }}</th>
                        <th class="text-center">{{ $texts['teachers_count'][$locale] }}</th>
                        <th>{{ $texts['status'][$locale] }}</th>
                        <th class="text-end pe-4">{{ $texts['actions'][$locale] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $dept->{'name_' . $locale} }}</div>
                                <div class="d-flex gap-2 small text-muted" style="font-size: 0.75rem;">
                                    <span>TK: {{ $dept->name_tk }}</span>
                                    <span>&bull;</span>
                                    <span>RU: {{ $dept->name_ru }}</span>
                                    <span>&bull;</span>
                                    <span>EN: {{ $dept->name_en }}</span>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-light p-2 text-primary" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <span class="small fw-semibold text-secondary">{{ $dept->institution->{'name_' . $locale} }}</span>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-semibold">
                                    <i class="bi bi-people me-1 text-primary"></i>{{ $dept->teacher_profiles_count }}
                                </span>
                            </td>

                            <td>
                                @if($dept->status === 1)
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">
                                        <i class="bi bi-check-circle me-1"></i>{{ $texts['active'][$locale] }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1">
                                        {{ $texts['inactive'][$locale] }}
                                    </span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.departments.edit', $dept->id) }}" class="btn btn-sm btn-light border rounded-pill px-3" title="{{ $texts['edit'][$locale] }}">
                                        <i class="bi bi-pencil me-1"></i> {{ $texts['edit'][$locale] }}
                                    </a>

                                    <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" onsubmit="return confirm('{{ $texts['delete_confirm'][$locale] }}')">
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
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-diagram-3 fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                {{ $texts['empty'][$locale] }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($departments->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $departments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection