@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Talyplar we okuwçylar',
            'ru' => 'Студенты и пользователи',
            'en' => 'Students & Users',
        ],
        'add_new' => [
            'tk' => 'Täze talyp goş',
            'ru' => 'Добавить студента',
            'en' => 'Add Student',
        ],
        'search_placeholder' => [
            'tk' => 'Ady ýa-da telefon belgisi boýunça...',
            'ru' => 'Поиск по имени или телефону...',
            'en' => 'Search by name or phone...',
        ],
        'search_btn' => [
            'tk' => 'Gözle',
            'ru' => 'Поиск',
            'en' => 'Search',
        ],
        'student' => [
            'tk' => 'Talyp / Ulanyjy',
            'ru' => 'Студент / Пользователь',
            'en' => 'Student / User',
        ],
        'phone' => [
            'tk' => 'Telefon belgisi',
            'ru' => 'Телефон',
            'en' => 'Phone',
        ],
        'email' => [
            'tk' => 'E-poçta',
            'ru' => 'Эл. почта',
            'en' => 'Email',
        ],
        'registered' => [
            'tk' => 'Agza bolan senesi',
            'ru' => 'Дата регистрации',
            'en' => 'Registered At',
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
        'blocked' => [
            'tk' => 'Petiklenen',
            'ru' => 'Заблокирован',
            'en' => 'Blocked',
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
            'tk' => 'Bu talyby ulgamdan doly pozmak isleýärsiňizmi?',
            'ru' => 'Удалить этого студента из системы?',
            'en' => 'Are you sure you want to delete this student from the system?',
        ],
        'empty' => [
            'tk' => 'Hiç hili talyp tapylmady.',
            'ru' => 'Студенты не найдены.',
            'en' => 'No students found.',
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
            <p class="text-muted small mb-0">{{ $students->total() }} {{ strtolower($texts['page_title'][$locale]) }}</p>
        </div>

        <a href="{{ route('admin.students.create') }}" class="btn btn-primary rounded-pill px-3 py-2 fw-semibold shadow-sm">
            <i class="bi bi-person-plus me-1"></i> {{ $texts['add_new'][$locale] }}
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.students.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="{{ $texts['search_placeholder'][$locale] }}" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3">
                        {{ $texts['search_btn'][$locale] }}
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
                        <th class="ps-4">{{ $texts['student'][$locale] }}</th>
                        <th>{{ $texts['phone'][$locale] }}</th>
                        <th>{{ $texts['email'][$locale] }}</th>
                        <th>{{ $texts['registered'][$locale] }}</th>
                        <th>{{ $texts['status'][$locale] }}</th>
                        <th class="text-end pe-4">{{ $texts['actions'][$locale] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    @if($student->avatar)
                                        <img src="{{ asset('storage/' . $student->avatar) }}" class="rounded-circle object-fit-cover shadow-xs border" width="40" height="40" alt="">
                                    @else
                                        <div class="rounded-circle bg-secondary bg-opacity-10 text-secondary d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark">{{ $student->name }}</div>
                                        @if($student->phone_verified_at)
                                            <span class="text-success small" style="font-size: 0.7rem;"><i class="bi bi-check-circle-fill me-1"></i>Tassyklanan</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="fw-semibold text-dark">{{ $student->phone }}</span>
                            </td>

                            <td>
                                <span class="small text-muted">{{ $student->email ?: '—' }}</span>
                            </td>

                            <td>
                                <span class="small text-muted">{{ $student->created_at->format('d.m.Y H:i') }}</span>
                            </td>

                            <td>
                                @if($student->status === 1)
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">
                                        <i class="bi bi-check-circle me-1"></i>{{ $texts['active'][$locale] }}
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">
                                        <i class="bi bi-slash-circle me-1"></i>{{ $texts['blocked'][$locale] }}
                                    </span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-light border rounded-pill px-3" title="{{ $texts['edit'][$locale] }}">
                                        <i class="bi bi-pencil me-1"></i> {{ $texts['edit'][$locale] }}
                                    </a>

                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('{{ $texts['delete_confirm'][$locale] }}')">
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
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                {{ $texts['empty'][$locale] }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection