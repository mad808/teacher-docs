@extends('front.layouts.app')

@php
    $locale = app()->getLocale();
    $texts = [
        'page_title' => [
            'tk' => 'Meniň hatlarym we çatlarym',
            'ru' => 'Мои сообщения и чаты',
            'en' => 'My Messages & Chats',
        ],
        'search_placeholder' => [
            'tk' => 'Söhbetdeş gözle...',
            'ru' => 'Поиск переписки...',
            'en' => 'Search conversations...',
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
        'no_messages' => [
            'tk' => 'Entek hiç hili hat ýok',
            'ru' => 'Пока нет сообщений',
            'en' => 'No messages yet',
        ],
        'you' => [
            'tk' => 'Siz:',
            'ru' => 'Вы:',
            'en' => 'You:',
        ],
        'attachment' => [
            'tk' => 'Faýl berkidilen',
            'ru' => 'Вложенный файл',
            'en' => 'Attachment',
        ],
        'empty' => [
            'tk' => 'Sizde entek hiç hili açyk gürrüňdeşlik ýok.',
            'ru' => 'У вас пока нет активных диалогов.',
            'en' => 'You do not have any conversations yet.',
        ],
        'find_teachers' => [
            'tk' => 'Mugallymlary gözläň',
            'ru' => 'Найти преподавателей',
            'en' => 'Browse Teachers',
        ],
    ];
@endphp

@section('title', $texts['page_title'][$locale])

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">{{ $texts['page_title'][$locale] }}</h4>
                    <p class="text-muted small mb-0">{{ $conversations->total() }} gürrüňdeşlik</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="list-group list-group-flush">
                    @forelse($conversations as $conv)
                        @php
                            $isTeacher = auth()->id() === $conv->teacher_id;
                            $partner = $isTeacher ? $conv->student : $conv->teacher;
                            $lastMsg = $conv->messages->first();
                            $hasUnread = $conv->messages()->where('sender_id', '!=', auth()->id())->whereNull('read_at')->exists();
                        @endphp
                        <a href="{{ route('chat.show', $conv->id) }}" class="list-group-item list-group-item-action p-3 p-md-4 border-bottom d-flex align-items-center gap-3 transition {{ $hasUnread ? 'bg-primary bg-opacity-10' : '' }}">
                            <div class="position-relative flex-shrink-0">
                                @if($partner->avatar)
                                    <img src="{{ asset('storage/' . $partner->avatar) }}" class="rounded-circle object-fit-cover border" width="52" height="52" alt="{{ $partner->name }}">
                                @else
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold fs-4" style="width: 52px; height: 52px;">
                                        {{ strtoupper(substr($partner->name, 0, 1)) }}
                                    </div>
                                @endif
                                @if($hasUnread)
                                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                @endif
                            </div>

                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex justify-content-between align-items-baseline mb-1">
                                    <h6 class="fw-bold text-dark mb-0 text-truncate pe-2">
                                        {{ $partner->name }}
                                        <span class="badge bg-light text-secondary border fw-normal ms-1" style="font-size: 0.7rem;">
                                            {{ $isTeacher ? $texts['student'][$locale] : $texts['teacher'][$locale] }}
                                        </span>
                                    </h6>
                                    @if($conv->last_message_at)
                                        <small class="text-muted flex-shrink-0" style="font-size: 0.75rem;">
                                            {{ $conv->last_message_at->diffForHumans() }}
                                        </small>
                                    @endif
                                </div>

                                <p class="text-muted small mb-0 text-truncate">
                                    @if($lastMsg)
                                        @if($lastMsg->sender_id === auth()->id())
                                            <span class="text-dark fw-semibold">{{ $texts['you'][$locale] }}</span>
                                        @endif
                                        @if($lastMsg->message)
                                            {{ $lastMsg->message }}
                                        @elseif($lastMsg->attachment_path)
                                            <i class="bi bi-paperclip me-1"></i>{{ $texts['attachment'][$locale] }}
                                        @endif
                                    @else
                                        <span class="fst-italic">{{ $texts['no_messages'][$locale] }}</span>
                                    @endif
                                </p>
                            </div>

                            <div class="text-muted flex-shrink-0">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>
                    @empty
                        <div class="p-5 text-center">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-chat-square-dots text-muted fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-2">{{ $texts['empty'][$locale] }}</h6>
                            <a href="{{ route('teachers.index') }}" class="btn btn-primary rounded-pill px-4 btn-sm fw-semibold">
                                <i class="bi bi-search me-1"></i> {{ $texts['find_teachers'][$locale] }}
                            </a>
                        </div>
                    @endforelse
                </div>

                @if($conversations->hasPages())
                    <div class="p-3 border-top">
                        {{ $conversations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection