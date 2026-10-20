@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Çatlar we hat ýazyşmalar',
            'ru' => 'Чаты и переписки',
            'en' => 'Conversations & Messages',
        ],
        'total_chats' => [
            'tk' => 'Jemi gürrüňdeşlikler',
            'ru' => 'Всего чатов',
            'en' => 'Total Chats',
        ],
        'teacher' => [
            'tk' => 'Mugallym',
            'ru' => 'Преподаватель',
            'en' => 'Teacher',
        ],
        'student' => [
            'tk' => 'Talyp / Okuwçy',
            'ru' => 'Студент',
            'en' => 'Student',
        ],
        'messages_count' => [
            'tk' => 'Hat sany',
            'ru' => 'Сообщений',
            'en' => 'Messages',
        ],
        'last_activity' => [
            'tk' => 'Soňky işjeňlik',
            'ru' => 'Последняя активность',
            'en' => 'Last Activity',
        ],
        'actions' => [
            'tk' => 'Hereketler',
            'ru' => 'Действия',
            'en' => 'Actions',
        ],
        'view_chat' => [
            'tk' => 'Çaty gör',
            'ru' => 'Открыть чат',
            'en' => 'View Chat',
        ],
        'delete' => [
            'tk' => 'Çaty poz',
            'ru' => 'Удалить чат',
            'en' => 'Delete Chat',
        ],
        'delete_confirm' => [
            'tk' => 'Bu gürrüňdeşligi we onuň ähli hatlaryny pozmak isleýärsiňizmi?',
            'ru' => 'Вы уверены, что хотите удалить этот чат и все сообщения?',
            'en' => 'Are you sure you want to delete this conversation and all its messages?',
        ],
        'empty' => [
            'tk' => 'Häzirlikçe hiç hili gürrüňdeşlik ýok.',
            'ru' => 'Переписок пока нет.',
            'en' => 'No conversations found.',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])
@section('page_title', $texts['page_title'][$locale])

@section('content')
<div class="container-fluid p-0">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold mb-0 text-dark">{{ $texts['page_title'][$locale] }}</h6>
                <small class="text-muted">{{ $texts['total_chats'][$locale] }}: {{ $conversations->total() }}</small>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">{{ $texts['teacher'][$locale] }}</th>
                        <th>{{ $texts['student'][$locale] }}</th>
                        <th class="text-center">{{ $texts['messages_count'][$locale] }}</th>
                        <th>{{ $texts['last_activity'][$locale] }}</th>
                        <th class="text-end pe-4">{{ $texts['actions'][$locale] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($conversations as $conversation)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    @if($conversation->teacher->avatar)
                                        <img src="{{ asset('storage/' . $conversation->teacher->avatar) }}" class="rounded-circle object-fit-cover shadow-xs" width="40" height="40" alt="">
                                    @else
                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($conversation->teacher->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $conversation->teacher->name }}</div>
                                        <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $conversation->teacher->phone }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($conversation->student->avatar)
                                        <img src="{{ asset('storage/' . $conversation->student->avatar) }}" class="rounded-circle object-fit-cover shadow-xs" width="40" height="40" alt="">
                                    @else
                                        <div class="rounded-circle bg-secondary bg-opacity-10 text-secondary d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($conversation->student->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $conversation->student->name }}</div>
                                        <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $conversation->student->phone }}</small>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-bold">
                                    <i class="bi bi-chat-text me-1"></i>{{ $conversation->messages_count }}
                                </span>
                            </td>

                            <td>
                                <span class="small text-muted">
                                    {{ $conversation->last_message_at ? $conversation->last_message_at->format('d.m.Y H:i') : $conversation->created_at->format('d.m.Y H:i') }}
                                </span>
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.conversations.show', $conversation->id) }}" class="btn btn-sm btn-primary rounded-pill px-3" title="{{ $texts['view_chat'][$locale] }}">
                                        <i class="bi bi-eye-fill me-1"></i> {{ $texts['view_chat'][$locale] }}
                                    </a>

                                    <form action="{{ route('admin.conversations.destroy', $conversation->id) }}" method="POST" onsubmit="return confirm('{{ $texts['delete_confirm'][$locale] }}')">
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
                                <i class="bi bi-chat-square-dots fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                {{ $texts['empty'][$locale] }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($conversations->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $conversations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection