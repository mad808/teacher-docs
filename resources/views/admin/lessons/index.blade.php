@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Dersler we ugurlar',
            'ru' => 'Предметы и дисциплины',
            'en' => 'Lessons & Subjects',
        ],
        'add_new' => [
            'tk' => 'Täze ders goş',
            'ru' => 'Добавить предмет',
            'en' => 'Add Lesson',
        ],
        'lesson' => [
            'tk' => 'Dersiň ady',
            'ru' => 'Название предмета',
            'en' => 'Lesson Name',
        ],
        'slug' => [
            'tk' => 'Slug / Salgy',
            'ru' => 'Слаг',
            'en' => 'Slug',
        ],
        'teachers' => [
            'tk' => 'Mugallymlar',
            'ru' => 'Преподаватели',
            'en' => 'Teachers',
        ],
        'documents' => [
            'tk' => 'Resminamalar',
            'ru' => 'Материалы',
            'en' => 'Documents',
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
            'tk' => 'Bu dersi pozmak isleýärsiňizmi?',
            'ru' => 'Вы уверены, что хотите удалить этот предмет?',
            'en' => 'Are you sure you want to delete this lesson?',
        ],
        'empty' => [
            'tk' => 'Hiç hili ders tapylmady.',
            'ru' => 'Предметы не найдены.',
            'en' => 'No lessons found.',
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
            <p class="text-muted small mb-0">{{ $lessons->total() }} {{ strtolower($texts['page_title'][$locale]) }}</p>
        </div>

        <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary rounded-pill px-3 py-2 fw-semibold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> {{ $texts['add_new'][$locale] }}
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">{{ $texts['lesson'][$locale] }}</th>
                        <th>{{ $texts['slug'][$locale] }}</th>
                        <th class="text-center">{{ $texts['teachers'][$locale] }}</th>
                        <th class="text-center">{{ $texts['documents'][$locale] }}</th>
                        <th>{{ $texts['status'][$locale] }}</th>
                        <th class="text-end pe-4">{{ $texts['actions'][$locale] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lessons as $lesson)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center p-2 fs-5" style="width: 42px; height: 42px;">
                                        <i class="bi {{ $lesson->icon ?: 'bi-journal-bookmark' }}"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $lesson->{'name_' . $locale} }}</div>
                                        <div class="d-flex gap-2 small text-muted" style="font-size: 0.75rem;">
                                            <span>TK: {{ $lesson->name_tk }}</span>
                                            <span>&bull;</span>
                                            <span>RU: {{ $lesson->name_ru }}</span>
                                            <span>&bull;</span>
                                            <span>EN: {{ $lesson->name_en }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <code class="small text-secondary">{{ $lesson->slug }}</code>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1 fw-semibold">
                                    <i class="bi bi-people me-1 text-primary"></i>{{ $lesson->teachers_count }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1 fw-semibold">
                                    <i class="bi bi-file-earmark-text me-1 text-success"></i>{{ $lesson->documents_count }}
                                </span>
                            </td>

                            <td>
                                @if($lesson->status === 1)
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
                                    <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="btn btn-sm btn-light border rounded-pill px-3" title="{{ $texts['edit'][$locale] }}">
                                        <i class="bi bi-pencil me-1"></i> {{ $texts['edit'][$locale] }}
                                    </a>

                                    <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('{{ $texts['delete_confirm'][$locale] }}')">
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
                                <i class="bi bi-journal-x fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                {{ $texts['empty'][$locale] }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lessons->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $lessons->links() }}
            </div>
        @endif
    </div>
</div>
@endsection