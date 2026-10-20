@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Gürrüňdeşlik maglumaty',
            'ru' => 'Детали переписки',
            'en' => 'Conversation Details',
        ],
        'back' => [
            'tk' => 'Yza dolan',
            'ru' => 'Назад',
            'en' => 'Back',
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
        'delete_conv' => [
            'tk' => 'Gürrüňdeşligi poz',
            'ru' => 'Удалить диалог',
            'en' => 'Delete Thread',
        ],
        'delete_conv_confirm' => [
            'tk' => 'Bu gürrüňdeşligi we onuň ähli hatlaryny doly pozmak isleýärsiňizmi?',
            'ru' => 'Удалить эту беседу и все вложенные сообщения?',
            'en' => 'Are you sure you want to delete this conversation and all its messages?',
        ],
        'delete_msg_confirm' => [
            'tk' => 'Bu haty pozmak isleýärsiňizmi?',
            'ru' => 'Удалить это сообщение?',
            'en' => 'Delete this message?',
        ],
        'no_messages' => [
            'tk' => 'Bu gürrüňdeşlikde entek hat ýok.',
            'ru' => 'В этом чате пока нет сообщений.',
            'en' => 'No messages in this conversation yet.',
        ],
        'attachment' => [
            'tk' => 'Faýl / Goşundy',
            'ru' => 'Вложение',
            'en' => 'Attachment',
        ],
        'download' => [
            'tk' => 'Ýükle',
            'ru' => 'Скачать',
            'en' => 'Download',
        ],
        'read' => [
            'tk' => 'Okaldy',
            'ru' => 'Прочитано',
            'en' => 'Read',
        ],
        'unread' => [
            'tk' => 'Okalmadyk',
            'ru' => 'Не прочитано',
            'en' => 'Unread',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])
@section('page_title', $texts['page_title'][$locale])

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('admin.conversations.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> {{ $texts['back'][$locale] }}
        </a>

        <form action="{{ route('admin.conversations.destroy', $conversation->id) }}" method="POST" onsubmit="return confirm('{{ $texts['delete_conv_confirm'][$locale] }}')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3">
                <i class="bi bi-trash3 me-1"></i> {{ $texts['delete_conv'][$locale] }}
            </button>
        </form>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    @if($conversation->teacher->avatar)
                        <img src="{{ asset('storage/' . $conversation->teacher->avatar) }}" class="rounded-circle object-fit-cover shadow-xs" width="52" height="52" alt="">
                    @else
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold fs-4" style="width: 52px; height: 52px;">
                            {{ strtoupper(substr($conversation->teacher->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-1">{{ $texts['teacher'][$locale] }}</span>
                        <h6 class="fw-bold mb-0 text-dark">{{ $conversation->teacher->name }}</h6>
                        <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $conversation->teacher->phone }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    @if($conversation->student->avatar)
                        <img src="{{ asset('storage/' . $conversation->student->avatar) }}" class="rounded-circle object-fit-cover shadow-xs" width="52" height="52" alt="">
                    @else
                        <div class="rounded-circle bg-secondary bg-opacity-10 text-secondary d-flex align-items-center justify-content-center fw-bold fs-4" style="width: 52px; height: 52px;">
                            {{ strtoupper(substr($conversation->student->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary mb-1">{{ $texts['student'][$locale] }}</span>
                        <h6 class="fw-bold mb-0 text-dark">{{ $conversation->student->name }}</h6>
                        <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $conversation->student->phone }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-light border-0 py-3 px-4">
            <h6 class="fw-bold mb-0 text-dark">
                <i class="bi bi-chat-dots me-2 text-primary"></i>
                {{ $conversation->teacher->name }} &bull; {{ $conversation->student->name }}
            </h6>
        </div>

        <div class="card-body p-4" style="max-height: 600px; overflow-y: auto;">
            <div class="d-flex flex-column gap-3">
                @forelse($conversation->messages as $msg)
                    @php
                        $isTeacher = $msg->sender_id === $conversation->teacher_id;
                    @endphp
                    <div class="d-flex flex-column {{ $isTeacher ? 'align-items-start' : 'align-items-end' }}">
                        <div class="d-flex align-items-center gap-2 mb-1 px-1">
                            <span class="badge {{ $isTeacher ? 'bg-primary' : 'bg-secondary' }} bg-opacity-10 {{ $isTeacher ? 'text-primary' : 'text-secondary' }} fw-bold" style="font-size: 0.7rem;">
                                {{ $msg->sender->name }} ({{ $isTeacher ? $texts['teacher'][$locale] : $texts['student'][$locale] }})
                            </span>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                {{ $msg->created_at->format('d.m.Y H:i') }}
                            </small>
                            @if($msg->read_at)
                                <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.65rem;">
                                    <i class="bi bi-check2-all"></i> {{ $texts['read'][$locale] }}
                                </span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning" style="font-size: 0.65rem;">
                                    <i class="bi bi-check2"></i> {{ $texts['unread'][$locale] }}
                                </span>
                            @endif
                        </div>

                        <div class="p-3 rounded-4 position-relative shadow-xs {{ $isTeacher ? 'bg-primary bg-opacity-10 text-dark rounded-top-start-0' : 'bg-light text-dark rounded-top-end-0 border' }}" style="max-width: 75%;">
                            <div class="text-break mb-1">{!! nl2br(e($msg->message)) !!}</div>

                            @if($msg->attachment_path)
                                <div class="mt-2 pt-2 border-top border-secondary border-opacity-10 d-flex align-items-center gap-2">
                                    <i class="bi bi-paperclip text-primary fs-5"></i>
                                    <span class="small fw-semibold text-truncate">{{ $texts['attachment'][$locale] }}</span>
                                    <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" download class="btn btn-sm btn-white border rounded-pill px-2 py-0 ms-auto text-primary">
                                        <i class="bi bi-download"></i> {{ $texts['download'][$locale] }}
                                    </a>
                                </div>
                            @endif

                            <div class="text-end mt-2 pt-1">
                                <form action="{{ route('admin.conversations.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('{{ $texts['delete_msg_confirm'][$locale] }}')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0 border-0" style="font-size: 0.75rem;" title="Poz">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-chat-square-dots fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        {{ $texts['no_messages'][$locale] }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection