@extends('front.layouts.app')

@php
    $locale = app()->getLocale();
    $user = auth()->user();
@endphp

@section('title', 'Mugallym Portaly - Resminamalar')

@section('content')
<!-- Header Nav -->
<div class="bg-light border-bottom py-3 mb-4">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Meniň Resminamalarym</h5>
            <p class="text-muted small mb-0">Okuw gollanmalaryny, leksiýalary we materiallary dolandyryň.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('teacher.portal.dashboard') }}" class="btn btn-white border btn-sm rounded-pill px-3 py-2 fw-semibold text-dark shadow-xs">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <button type="button" class="btn btn-success btn-sm rounded-pill px-4 py-2 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadDocModal">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Täze Faýl Ýükle
            </button>
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Ýalňyşlyk:</strong>
            <ul class="mb-0 mt-2 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Documents List Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
        @if($documents->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-muted">
                        <tr>
                            <th>Resminama</th>
                            <th>Degişli Dersi</th>
                            <th>Göwrümi</th>
                            <th>Ýüklemeler</th>
                            <th>Status</th>
                            <th>Senesi</th>
                            <th class="text-end">Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $doc)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 bg-light p-2 border text-success d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bi bi-file-earmark-arrow-down fs-4"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $doc->{'title_' . $locale} }}</div>
                                            <small class="text-muted">{{ $doc->file_name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $doc->lesson?->{'name_' . $locale} ?? 'Umumy' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary text-uppercase me-1">
                                        {{ $doc->file_extension }}
                                    </span>
                                    <small class="text-muted">{{ round($doc->file_size / 1024, 1) }} KB</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark"><i class="bi bi-download text-muted me-1"></i>{{ $doc->downloads_count }}</span>
                                </td>
                                <td>
                                    @if($doc->is_public)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 small">Açyk</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 small">Ýapyk</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $doc->created_at->format('d.m.Y H:i') }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" download class="btn btn-light btn-sm rounded-circle border" title="Ýükläp al" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-download text-primary"></i>
                                        </a>

                                        <form action="{{ route('teacher.portal.documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Bu faýly pozmak isleýärsiňizmi?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-circle border text-danger" title="Poz" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $documents->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-folder-x fs-1 d-block mb-3 text-secondary opacity-50"></i>
                <h5 class="fw-bold text-dark">Hiç hili resminama tapylmady</h5>
                <p class="text-muted mb-4">Birinji okuw resminamaňyzy ýükläp başlaň.</p>
                <button type="button" class="btn btn-success rounded-pill px-4 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#uploadDocModal">
                    <i class="bi bi-plus-circle me-1"></i> Resminama Goş
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadDocModal" tabindex="-1" aria-labelledby="uploadDocModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('teacher.portal.documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom px-4 pt-4 pb-3">
                    <h5 class="modal-title fw-bold text-dark" id="uploadDocModalLabel">
                        <i class="bi bi-cloud-arrow-up-fill text-success me-2"></i>Täze Resminama Ýüklemek
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Language Nav Tabs -->
                    <ul class="nav nav-pills nav-fill mb-3 bg-light p-1 rounded-pill" id="docLangTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill py-2 small fw-semibold" id="doc-tk-tab" data-bs-toggle="pill" data-bs-target="#doc-tk" type="button" role="tab">Türkmençe</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill py-2 small fw-semibold" id="doc-ru-tab" data-bs-toggle="pill" data-bs-target="#doc-ru" type="button" role="tab">Русский</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill py-2 small fw-semibold" id="doc-en-tab" data-bs-toggle="pill" data-bs-target="#doc-en" type="button" role="tab">English</button>
                        </li>
                    </ul>

                    <div class="tab-content mb-4" id="docLangTabContent">
                        <!-- TK -->
                        <div class="tab-pane fade show active" id="doc-tk" role="tabpanel">
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Resminamanyň ady (TM) <span class="text-danger">*</span></label>
                                <input type="text" name="title_tk" class="form-control rounded-3" placeholder="Mysaly: Kiberhowpsuzlyk esaslary leksiýa 1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Düşündiriş (TM)</label>
                                <textarea name="description_tk" rows="2" class="form-control rounded-3" placeholder="Resminama barada gysgaça..."></textarea>
                            </div>
                        </div>

                        <!-- RU -->
                        <div class="tab-pane fade" id="doc-ru" role="tabpanel">
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Название документа (RU) <span class="text-danger">*</span></label>
                                <input type="text" name="title_ru" class="form-control rounded-3" placeholder="Пример: Основы кибербезопасности лекция 1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Описание (RU)</label>
                                <textarea name="description_ru" rows="2" class="form-control rounded-3" placeholder="Краткое описание документа..."></textarea>
                            </div>
                        </div>

                        <!-- EN -->
                        <div class="tab-pane fade" id="doc-en" role="tabpanel">
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Document Title (EN) <span class="text-danger">*</span></label>
                                <input type="text" name="title_en" class="form-control rounded-3" placeholder="Example: Cybersecurity Fundamentals Lecture 1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Description (EN)</label>
                                <textarea name="description_en" rows="2" class="form-control rounded-3" placeholder="Short description of the document..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Degişli ders</label>
                            <select name="lesson_id" class="form-select rounded-3">
                                <option value="">— Umumy / Saýlanmadyk —</option>
                                @foreach($lessons as $lesson)
                                    <option value="{{ $lesson->id }}">{{ $lesson->{'name_' . $locale} }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Faýly saýlaň <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control rounded-3" required accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip">
                            <small class="text-muted" style="font-size: 0.75rem;">PDF, DOC, DOCX, PPT, PPTX, XLS, ZIP (iň köp 50 MB)</small>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_public" value="1" id="isPublicSwitch" checked>
                                <label class="form-check-label fw-semibold small text-dark" for="isPublicSwitch">
                                    Profiliňizde hemmelere açyk görkezilsin
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Ýatyr</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-semibold">
                        <i class="bi bi-upload me-1"></i> Ýükle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection