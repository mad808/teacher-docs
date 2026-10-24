@extends('front.layouts.app')

@php
    $locale = app()->getLocale();
    $user = auth()->user();
@endphp

@section('title', 'Mugallym Portaly - Dashboard')

@section('content')
<div class="bg-light border-bottom py-3 mb-4">
    <div class="container">
        <!-- Portal Nav Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle object-fit-cover border shadow-sm" width="55" height="55" alt="{{ $user->name }}">
                    @else
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center fw-bold fs-4 border" style="width: 55px; height: 55px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    @if($profile->is_verified)
                        <span class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-1 d-flex align-items-center justify-content-center border border-white" style="width: 18px; height: 18px; font-size: 0.65rem;" title="Tassyklanan">
                            <i class="bi bi-patch-check-fill"></i>
                        </span>
                    @endif
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">{{ $user->name }}</h5>
                    <p class="text-muted small mb-0">{{ $profile->{'title_' . $locale} ?: 'Mugallym' }} &bull; {{ $profile->institution?->{'name_' . $locale} ?? 'Okuw jaýy bellenmedik' }}</p>
                </div>
            </div>

            <!-- Portal Links -->
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('teacher.portal.dashboard') }}" class="btn btn-success btn-sm rounded-pill px-3 py-2 fw-semibold">
                    <i class="bi bi-grid-fill me-1"></i> Dashboard
                </a>
                <a href="{{ route('teacher.portal.documents') }}" class="btn btn-white border btn-sm rounded-pill px-3 py-2 fw-semibold text-dark shadow-xs">
                    <i class="bi bi-folder2-open me-1 text-success"></i> Resminamalar
                </a>
                <a href="{{ route('teacher.portal.profile.edit') }}" class="btn btn-white border btn-sm rounded-pill px-3 py-2 fw-semibold text-dark shadow-xs">
                    <i class="bi bi-person-gear me-1 text-primary"></i> Profili sazla
                </a>
                @if(Route::has('teachers.show'))
                    <a href="{{ route('teachers.show', $profile->id) }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 fw-semibold">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Profili gör
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistic Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 bg-success bg-opacity-10 text-success p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-file-earmark-text fs-3"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark">{{ $documents_count }}</div>
                        <div class="text-muted small">Ýüklenen Faýllar</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 bg-primary bg-opacity-10 text-primary p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-cloud-arrow-down fs-3"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark">{{ number_format($downloads_total) }}</div>
                        <div class="text-muted small">Jemi Ýüklemeler</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 bg-info bg-opacity-10 text-info p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-chat-dots fs-3"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark">{{ $conversations_count }}</div>
                        <div class="text-muted small">Gelen Hatlar</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 bg-warning bg-opacity-10 text-warning p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-star-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark">{{ number_format($profile->rating ?? 5.0, 1) }}</div>
                        <div class="text-muted small">{{ $profile->reviews_count ?? 0 }} Seslenme</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts & Latest Uploads -->
    <div class="row g-4">
        <!-- Recent Documents -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <h6 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history text-success me-2"></i>Soňky ýüklenen materiallar</h6>
                    </div>
                    <a href="{{ route('teacher.portal.documents') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-semibold">
                        Ählisini gör <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                @if($latest_documents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small text-muted">
                                <tr>
                                    <th>Faýl ady</th>
                                    <th>Dersi</th>
                                    <th>Görnüşi</th>
                                    <th>Ýüklemeler</th>
                                    <th>Senesi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latest_documents as $doc)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-file-earmark-text text-success fs-5"></i>
                                                <span class="fw-semibold text-dark">{{ Str::limit($doc->{'title_' . $locale}, 30) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                {{ $doc->lesson?->{'name_' . $locale} ?? 'Umumy' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary text-uppercase">
                                                {{ $doc->file_extension }}
                                            </span>
                                        </td>
                                        <td><i class="bi bi-download text-muted me-1"></i>{{ $doc->downloads_count }}</td>
                                        <td class="text-muted small">{{ $doc->created_at->format('d.m.Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-cloud-upload fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        <p class="mb-3">Entek hiç hili okuw resminamasy ýüklenmedi.</p>
                        <a href="{{ route('teacher.portal.documents') }}" class="btn btn-success btn-sm rounded-pill px-4">
                            <i class="bi bi-plus-lg me-1"></i> Ilkinji faýly ýükle
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Summary / Shortcuts -->
        <div class="col-lg-4">
            <!-- Profile Status Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
                <h6 class="fw-bold text-dark border-bottom pb-3 mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Profiliň ýagdaýy</h6>
                <ul class="list-unstyled d-flex flex-column gap-3 small mb-0">
                    <li class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Tassyklama statusy:</span>
                        @if($profile->is_verified)
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Tassyklanan</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">Garaşylýar</span>
                        @endif
                    </li>
                    <li class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Iş tejribesi:</span>
                        <span class="fw-bold text-dark">{{ $profile->experience_years }} ýyl</span>
                    </li>
                    <li class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Birikdirilen dersler:</span>
                        <span class="badge bg-light text-dark border">{{ $profile->lessons()->count() }} ders</span>
                    </li>
                </ul>
            </div>

            <!-- Quick Action Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-success bg-opacity-10 border-success border-opacity-25 p-4 text-center">
                <i class="bi bi-file-earmark-arrow-up-fill text-success fs-1 mb-2"></i>
                <h6 class="fw-bold text-dark mb-1">Täze material paýlaş</h6>
                <p class="text-muted small mb-3">Talyplar we beýleki hünärmenler üçin okuw gollanmalaryny ýükläň.</p>
                <a href="{{ route('teacher.portal.documents') }}" class="btn btn-success rounded-pill px-4 py-2 fw-semibold w-100">
                    <i class="bi bi-plus-circle me-1"></i> Resminama goş
                </a>
            </div>
        </div>
    </div>
</div>
@endsection