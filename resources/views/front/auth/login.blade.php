@extends('front.layouts.app')

@php
    $locale = app()->getLocale();
    $translations = [
        'login_title' => [
            'tk' => 'Ulgama girmek',
            'ru' => 'Вход в систему',
            'en' => 'Sign In',
        ],
        'login_subtitle' => [
            'tk' => 'Telefon belgiňiz arkaly SMS kody alyp ulgama giriň',
            'ru' => 'Войдите в систему с помощью SMS-кода на ваш номер',
            'en' => 'Enter your phone number to receive an SMS code',
        ],
        'phone_label' => [
            'tk' => 'Telefon belgiňiz',
            'ru' => 'Номер телефона',
            'en' => 'Phone Number',
        ],
        'name_label' => [
            'tk' => 'Adyňyz (täze ulanyjylar üçin)',
            'ru' => 'Ваше имя (для новых пользователей)',
            'en' => 'Your Name (for new users)',
        ],
        'send_code' => [
            'tk' => 'SMS kody ugrat',
            'ru' => 'Отправить SMS код',
            'en' => 'Send SMS Code',
        ],
        'otp_title' => [
            'tk' => 'SMS tassyklama kody',
            'ru' => 'Код подтверждения SMS',
            'en' => 'SMS Verification Code',
        ],
        'otp_sent_to' => [
            'tk' => 'Kod ugradyldy:',
            'ru' => 'Код отправлен на:',
            'en' => 'Code sent to:',
        ],
        'change_phone' => [
            'tk' => 'Belgini üýtget',
            'ru' => 'Изменить номер',
            'en' => 'Change number',
        ],
        'verify_btn' => [
            'tk' => 'Tassykla we gir',
            'ru' => 'Подтвердить и войти',
            'en' => 'Verify & Login',
        ],
        'resend_in' => [
            'tk' => 'Täzeden ugratmak:',
            'ru' => 'Повторить через:',
            'en' => 'Resend in:',
        ],
        'resend_code' => [
            'tk' => 'Kody täzeden ugrat',
            'ru' => 'Отправить код повторно',
            'en' => 'Resend code',
        ],
        'enter_phone_warning' => [
            'tk' => 'Telefon belgiňizi giriziň',
            'ru' => 'Пожалуйста, введите номер телефона',
            'en' => 'Please enter your phone number',
        ],
        'enter_code_warning' => [
            'tk' => '6 belgili tassyklama koduny giriziň',
            'ru' => 'Введите 6-значный проверочный код',
            'en' => 'Please enter the 6-digit verification code',
        ],
    ];
@endphp

@section('title', $translations['login_title'][$locale])

@section('content')
<div class="container py-5 my-md-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-shield-lock-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">{{ $translations['login_title'][$locale] }}</h4>
                    <p class="text-muted small mb-0">{{ $translations['login_subtitle'][$locale] }}</p>
                </div>

                <div id="step-phone">
                    <form id="form-send-otp">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-dark">{{ $translations['name_label'][$locale] }}</label>
                            <input type="text" id="user-name" class="form-control" placeholder="Meselem: Eziz">
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-dark">{{ $translations['phone_label'][$locale] }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0 fw-semibold">+993</span>
                                <input type="tel" id="user-phone" class="form-control border-start-0 ps-1" placeholder="65123456" maxlength="8" required autofocus>
                            </div>
                        </div>

                        <button type="submit" id="btn-send-otp" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <span>{{ $translations['send_code'][$locale] }}</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </form>
                </div>

                <div id="step-otp" style="display: none;">
                    <div class="alert alert-light border small text-center mb-4">
                        <div class="text-muted">{{ $translations['otp_sent_to'][$locale] }}</div>
                        <div class="fw-bold text-dark fs-6" id="display-phone">+993</div>
                        <a href="javascript:void(0)" id="btn-change-phone" class="text-primary small text-decoration-none mt-1 d-inline-block">
                            <i class="bi bi-pencil-square me-1"></i>{{ $translations['change_phone'][$locale] }}
                        </a>
                    </div>

                    <form id="form-verify-otp">
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-dark text-center w-100 mb-2">{{ $translations['otp_title'][$locale] }}</label>
                            <input type="text" id="otp-code" class="form-control text-center fs-3 fw-bold tracking-widest letter-spacing-2" maxlength="6" placeholder="______" required autocomplete="one-time-code">
                        </div>

                        <button type="submit" id="btn-verify-otp" class="btn btn-primary w-100 py-2 fw-semibold mb-3 d-flex align-items-center justify-content-center gap-2">
                            <span>{{ $translations['verify_btn'][$locale] }}</span>
                            <i class="bi bi-check2-circle"></i>
                        </button>

                        <div class="text-center small">
                            <span id="timer-box" class="text-muted">
                                {{ $translations['resend_in'][$locale] }} <span id="timer-count" class="fw-bold text-dark">60</span>s
                            </span>
                            <a href="javascript:void(0)" id="btn-resend-otp" class="text-primary fw-semibold text-decoration-none" style="display: none;">
                                {{ $translations['resend_code'][$locale] }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .letter-spacing-2 {
        letter-spacing: 0.5rem;
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let timerInterval = null;

        function startTimer(seconds) {
            clearInterval(timerInterval);
            let timeLeft = seconds;
            $('#timer-box').show();
            $('#btn-resend-otp').hide();
            $('#timer-count').text(timeLeft);

            timerInterval = setInterval(function() {
                timeLeft--;
                $('#timer-count').text(timeLeft);

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    $('#timer-box').hide();
                    $('#btn-resend-otp').show();
                }
            }, 1000);
        }

        $('#form-send-otp').on('submit', function(e) {
            e.preventDefault();
            const phoneInput = $('#user-phone').val().trim();
            const nameInput = $('#user-name').val().trim();

            if (!phoneInput) {
                toastr.warning("{{ $translations['enter_phone_warning'][$locale] }}");
                return;
            }

            const fullPhone = '+993' + phoneInput.replace(/\D/g, '');
            const submitBtn = $('#btn-send-otp');
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

            $.ajax({
                url: "{{ route('auth.send-otp') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    phone: fullPhone,
                    name: nameInput
                },
                success: function(res) {
                    submitBtn.prop('disabled', false).html('<span>{{ $translations['send_code'][$locale] }}</span> <i class="bi bi-arrow-right"></i>');

                    if (res.success) {
                        $('#display-phone').text(fullPhone);
                        $('#step-phone').hide();
                        $('#step-otp').fadeIn();
                        $('#otp-code').val('').focus();

                        if (res.dev_code) {
                            $('#otp-code').val(res.dev_code);
                            toastr.info(res.message);
                        } else {
                            toastr.success(res.message);
                        }

                        startTimer(60);
                    }
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html('<span>{{ $translations['send_code'][$locale] }}</span> <i class="bi bi-arrow-right"></i>');
                    const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Error sending SMS';
                    toastr.error(msg);
                }
            });
        });

        $('#btn-resend-otp').on('click', function() {
            $('#form-send-otp').trigger('submit');
        });

        $('#btn-change-phone').on('click', function() {
            clearInterval(timerInterval);
            $('#step-otp').hide();
            $('#step-phone').fadeIn();
            $('#user-phone').focus();
        });

        $('#form-verify-otp').on('submit', function(e) {
            e.preventDefault();
            const fullPhone = $('#display-phone').text().trim();
            const code = $('#otp-code').val().trim();
            const name = $('#user-name').val().trim();

            if (!code || code.length !== 6) {
                toastr.warning("{{ $translations['enter_code_warning'][$locale] }}");
                return;
            }

            const verifyBtn = $('#btn-verify-otp');
            verifyBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

            $.ajax({
                url: "{{ route('auth.verify-otp') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    phone: fullPhone,
                    code: code,
                    name: name
                },
                success: function(res) {
                    if (res.success) {
                        toastr.success('Success');
                        setTimeout(function() {
                            window.location.href = res.redirect;
                        }, 500);
                    }
                },
                error: function(xhr) {
                    verifyBtn.prop('disabled', false).html('<span>{{ $translations['verify_btn'][$locale] }}</span> <i class="bi bi-check2-circle"></i>');
                    const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Invalid code';
                    toastr.error(msg);
                }
            });
        });
    });
</script>
@endsection