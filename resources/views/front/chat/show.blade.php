@extends('front.layouts.app')

@php
    $locale = app()->getLocale();
    $userId = auth()->id();
    $isTeacher = $userId === $conversation->teacher_id;
    $partner = $isTeacher ? $conversation->student : $conversation->teacher;
    $texts = [
        'back' => [
            'tk' => 'Çatlara dolan',
            'ru' => 'Ко всем чатам',
            'en' => 'All Chats',
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
        'type_message' => [
            'tk' => 'Hatyňyzy ýazyň...',
            'ru' => 'Введите сообщение...',
            'en' => 'Type a message...',
        ],
        'send' => [
            'tk' => 'Ugrat',
            'ru' => 'Отправить',
            'en' => 'Send',
        ],
        'attachment' => [
            'tk' => 'Faýl berkidiň',
            'ru' => 'Прикрепить файл',
            'en' => 'Attach file',
        ],
        'download' => [
            'tk' => 'Ýükle',
            'ru' => 'Скачать',
            'en' => 'Download',
        ],
    ];
@endphp

@section('title', $partner->name . ' - Çat')

@section('content')
<div class="container py-3 py-md-4">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column" style="height: 78vh;">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center flex-shrink-0">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('chat.index') }}" class="btn btn-light btn-sm rounded-circle p-2 border" title="{{ $texts['back'][$locale] }}">
                            <i class="bi bi-arrow-left"></i>
                        </a>

                        <div class="position-relative">
                            @if($partner->avatar)
                                <img src="{{ asset('storage/' . $partner->avatar) }}" class="rounded-circle object-fit-cover border" width="44" height="44" alt="{{ $partner->name }}">
                            @else
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 44px; height: 44px;">
                                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div>
                            <h6 class="fw-bold text-dark mb-0">{{ $partner->name }}</h6>
                            <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.7rem;">
                                {{ $isTeacher ? $texts['student'][$locale] : $texts['teacher'][$locale] }}
                            </span>
                        </div>
                    </div>

                    @if(!$isTeacher && $partner->teacherProfile)
                        <a href="{{ route('teachers.show', $partner->teacherProfile->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="bi bi-person me-1"></i> Profil
                        </a>
                    @endif
                </div>

                <div class="card-body p-3 p-md-4 flex-grow-1 overflow-y-auto" id="chat-messages-container" style="background-color: #f8fafc;">
                    <div class="d-flex flex-column gap-3">
                        @foreach($conversation->messages as $msg)
                            @php
                                $mine = $msg->sender_id === $userId;
                            @endphp
                            <div class="d-flex flex-column {{ $mine ? 'align-items-end' : 'align-items-start' }}">
                                <div class="d-flex align-items-center gap-2 mb-1 px-1">
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        {{ $msg->created_at->format('H:i') }}
                                    </small>
                                    @if($mine)
                                        @if($msg->read_at)
                                            <i class="bi bi-check2-all text-primary" style="font-size: 0.8rem;" title="Okaldy"></i>
                                        @else
                                            <i class="bi bi-check2 text-muted" style="font-size: 0.8rem;"></i>
                                        @endif
                                    @endif
                                </div>

                                <div class="p-3 rounded-4 shadow-xs {{ $mine ? 'bg-primary text-white rounded-top-end-0' : 'bg-white text-dark rounded-top-start-0 border' }}" style="max-width: 80%; word-break: break-word;">
                                    @if($msg->message)
                                        <div class="lh-base">{!! nl2br(e($msg->message)) !!}</div>
                                    @endif

                                    @if($msg->attachment_path)
                                        <div class="mt-2 pt-2 border-top {{ $mine ? 'border-white border-opacity-25' : 'border-secondary border-opacity-10' }} d-flex align-items-center gap-2">
                                            <i class="bi bi-paperclip fs-5"></i>
                                            <span class="small fw-semibold text-truncate">Faýl</span>
                                            <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" download class="btn btn-sm {{ $mine ? 'btn-light text-primary' : 'btn-primary' }} rounded-pill px-2 py-0 ms-auto">
                                                <i class="bi bi-download"></i> {{ $texts['download'][$locale] }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card-footer bg-white border-top p-3 flex-shrink-0">
                    <form action="{{ route('chat.send', $conversation->id) }}" method="POST" enctype="multipart/form-data" id="chat-form">
                        @csrf
                        <div id="attachment-preview" class="mb-2 p-2 bg-light rounded-3 d-flex align-items-center justify-content-between" style="display: none !important;">
                            <span class="small text-muted text-truncate" id="attachment-filename"></span>
                            <button type="button" class="btn btn-link text-danger p-0 border-0" id="btn-remove-attachment">
                                <i class="bi bi-x-circle-fill"></i>
                            </button>
                        </div>

                        <div class="input-group">
                            <label class="btn btn-light border border-end-0 text-muted px-3" for="attachment-input" title="{{ $texts['attachment'][$locale] }}">
                                <i class="bi bi-paperclip fs-5"></i>
                            </label>
                            <input type="file" name="attachment" id="attachment-input" class="d-none" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip">

                            <input type="text" name="message" id="message-input" class="form-control border-start-0 border-end-0 px-3 py-2 shadow-none" placeholder="{{ $texts['type_message'][$locale] }}" autocomplete="off" required>

                            <button class="btn btn-primary px-4 fw-semibold d-flex align-items-center gap-2" type="submit">
                                <span>{{ $texts['send'][$locale] }}</span>
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const container = document.getElementById('chat-messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }

        $('#attachment-input').on('change', function() {
            if (this.files && this.files[0]) {
                $('#attachment-filename').text(this.files[0].name);
                $('#attachment-preview').removeAttr('style');
                $('#message-input').removeAttr('required');
            }
        });

        $('#btn-remove-attachment').on('click', function() {
            $('#attachment-input').val('');
            $('#attachment-preview').attr('style', 'display: none !important;');
            $('#message-input').attr('required', 'required');
        });
    });
</script>
@endsection