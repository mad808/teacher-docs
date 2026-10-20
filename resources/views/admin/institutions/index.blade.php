@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Okuw jaýlary we bilim merkezleri',
            'ru' => 'Учебные заведения и центры',
            'en' => 'Institutions & Centers',
        ],
        'add_new' => [
            'tk' => 'Täze okuw jaýy goş',
            'ru' => 'Добавить заведение',
            'en' => 'Add Institution',
        ],
        'institution' => [
            'tk' => 'Okuw jaýy',
            'ru' => 'Учреждение',
            'en' => 'Institution',
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
        'departments' => [
            'tk' => 'Kafedralar',
            'ru' => 'Кафедры',
            'en' => 'Departments',
        ],
        'teachers' => [
            'tk' => 'Mugallymlar',
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
            'tk' => 'Bu okuw jaýyny pozmak isleýärsiňizmi? Oňa bagly kafedralar we maglumatlar hem pozulyp biler.',
            'ru' => 'Удалить это учебное заведение? Все связанные кафедры также могут быть затронуты.',
            'en' => 'Are you sure you want to delete this institution? All related departments will also be affected.',
        ],
        'empty' => [
            'tk' => 'Hiç hili okuw jaýy tapylmady.',
            'ru' => 'Учебные заведения не найдены.',
            'en' => 'No institutions found.',
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
            <p class="text-muted small mb-0">{{ $institutions->total() }} {{ strtolower($texts['page_title'][$locale]) }}</p>
        </div>

        <a href="{{ route('admin.institutions.create') }}" class="btn btn-primary rounded-pill px-3 py-2 fw-semibold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> {{ $texts['add_new'][$locale] }}
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">{{ $texts['institution'][$locale] }}</th>
                        <th>{{ $texts['type'][$locale] }}</th>
                        <th>{{ $texts['city'][$locale] }}</th>
                        <th class="text-center">{{ $texts['departments'][$locale] }}</th>
                        <th class="text-center">{{ $texts['teachers'][$locale] }}</th>
                        <th>{{ $texts['status'][$locale] }}</th>
                        <th class="text-end pe-4">{{ $texts['actions'][$locale] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($institutions as $inst)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    @if($inst->logo)
                                        <img src="{{ asset('storage/' . $inst->logo) }}" class="rounded-3 object-fit-contain shadow-xs border" width="44" height="44" alt="">
                                    @else
                                        <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 44px; height: 44px;">
                                            <i class="bi bi-building"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark">{{ $inst->{'name_' . $locale} }}</div>
                                        <div class="d-flex gap-2 small text-muted" style="font-size: 0.75rem;">
                                            @if($inst->phone)
                                                <span><i class="bi bi-telephone me-1"></i>{{ $inst->phone }}</span>
                                            @endif
                                            @if($inst->website)
                                                <span>&bull;</span>
                                                <a href="{{ $inst->website }}" target="_blank" class="text-decoration-none text-muted">
                                                    <i class="bi bi-globe me-1"></i>{{ parse_url($inst->website, PHP_URL_HOST) ?? $inst->website }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border text-uppercase" style="font-size: 0.725rem;">
                                    {{ $inst->type }}
                                </span>
                            </td>

                            <td>
                                <span class="small text-secondary">{{ $inst->city ?: '—' }}</span>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1 fw-semibold">
                                    <i class="bi bi-diagram-3 me-1 text-primary"></i>{{ $inst->departments_count }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1 fw-semibold">
                                    <i class="bi bi-people me-1 text-success"></i>{{ $inst->teacher_profiles_count }}
                                </span>
                            </td>

                            <td>
                                @if($inst->status === 1)
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
                                    <a href="{{ route('admin.institutions.edit', $inst->id) }}" class="btn btn-sm btn-light border rounded-pill px-3" title="{{ $texts['edit'][$locale] }}">
                                        <i class="bi bi-pencil me-1"></i> {{ $texts['edit'][$locale] }}
                                    </a>

                                    <form action="{{ route('admin.institutions.destroy', $inst->id) }}" method="POST" onsubmit="return confirm('{{ $texts['delete_confirm'][$locale] }}')">
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
                                <i class="bi bi-building-slash fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                {{ $texts['empty'][$locale] }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($institutions->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $institutions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection