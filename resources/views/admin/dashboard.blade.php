@extends('admin.layouts.app')

@section('title', __('Dashboard'))
@section('page_title', __('Dashboard'))

@php
    $locale = app()->getLocale();
@endphp

@section('content')
<div class="container-fluid p-0">
    <div class="row g-3 mb-4">
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-person-video3 fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">{{ __('Total Teachers') }}</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['teachers_count']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">{{ __('Total Students') }}</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['students_count']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-info bg-opacity-10 text-info">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">{{ __('Total Institutions') }}</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['institutions_count']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-journal-bookmark-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">{{ __('Total Lessons') }}</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['lessons_count']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-file-earmark-arrow-down-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">{{ __('Total Documents') }}</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['documents_count']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-secondary bg-opacity-10 text-secondary">
                        <i class="bi bi-chat-left-dots-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">{{ __('Total Chats') }}</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['conversations_count']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">{{ __('Latest Registered Teachers') }}</h6>
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-outline-primary">{{ __('View All') }}</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Institution') }}</th>
                                <th>{{ __('Experience') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_teachers as $teacher)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($teacher->user->avatar)
                                                <img src="{{ asset('storage/' . $teacher->user->avatar) }}" class="rounded-circle object-fit-cover" width="36" height="36" alt="">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 36px; height: 36px;">
                                                    {{ strtoupper(substr($teacher->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $teacher->user->name }}</div>
                                                <small class="text-muted">{{ $teacher->user->phone }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="small">{{ $teacher->institution?->{'name_' . $locale} ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $teacher->experience_years }} {{ __('years') }}</span>
                                    </td>
                                    <td>
                                        @if($teacher->is_verified)
                                            <span class="badge bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle me-1"></i>{{ __('Verified') }}</span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ __('Unverified') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-sm btn-light border">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">{{ __('No data available') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">{{ __('Latest Uploaded Documents') }}</h6>
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-sm btn-outline-primary">{{ __('View All') }}</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Teacher') }}</th>
                                <th>{{ __('Downloads') }}</th>
                                <th class="text-end">{{ __('File') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_documents as $doc)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark text-truncate" style="max-width: 160px;">
                                            {{ $doc->{'title_' . $locale} }}
                                        </div>
                                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">{{ $doc->file_extension }} &bull; {{ round($doc->file_size / 1024, 1) }} KB</small>
                                    </td>
                                    <td>
                                        <span class="small text-muted">{{ $doc->teacherProfile?->user?->name ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $doc->downloads_count }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.documents.download', $doc->id) }}" class="btn btn-sm btn-light border text-primary">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">{{ __('No data available') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection