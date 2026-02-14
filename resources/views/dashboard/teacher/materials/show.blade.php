@extends('dashboard.layout.master')

@section('title', 'Material Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div class="d-flex flex-column">
                                <h4 class="mb-1">Inspire Coaching Academy</h4>
                                <p class="mb-0 text-white-50">
                                    <small>
                                        <i class="far fa-calendar-alt mr-2"></i>
                                        Created: {{ $material->created_at->format('M d, Y h:i A') }}
                                    </small>
                                </p>
                            </div>
                            <a href="{{ route('materials.index') }}" class="btn btn-light btn-sm mt-2 mt-md-0">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Materials
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Material Header Info -->

                        <div class="row mb-4 align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <!-- Material Type Badge with Icon -->
                                    <!-- Material Title -->
                                    <h2 class="mb-0 text-dark fw-bold">{{ $material->title }}</h2>
                                </div>
                                <!-- Meta Information -->
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <!-- Teacher Info -->
                                    <div class="d-flex align-items-center bg-light rounded-pill px-3 py-1">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title bg-white rounded-circle text-primary">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted small">Teacher</p>
                                            <p class="mb-0 fw-medium">{{ $teacher->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <!-- Class Info -->
                                    <div class="d-flex align-items-center bg-light rounded-pill px-3 py-1">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title bg-white rounded-circle text-success">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted small">Class</p>
                                            <p class="mb-0 fw-medium">{{ $material->class->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <!-- Updated Date -->
                                    <div class="d-flex align-items-center bg-light rounded-pill px-3 py-1">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title bg-white rounded-circle text-warning">
                                                <i class="fas fa-sync-alt"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted small">Last Updated</p>
                                            <p class="mb-0 fw-medium">{{ $material->updated_at->format('M d, Y h:i A') }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Material Type Badge -->
                                    <div class="d-flex align-items-center bg-light rounded-pill px-3 py-1">
                                        <span
                                            class="badge rounded-pill p-2 border-0
            @if ($material->type == 'document') bg-info
            @elseif($material->type == 'video') bg-primary
            @elseif($material->type == 'image') bg-success
            @else bg-secondary @endif">
                                            <i
                                                class="fas
                @if ($material->type == 'document') fa-file-alt
                @elseif($material->type == 'video') fa-video
                @elseif($material->type == 'image') fa-image
                @else fa-file @endif me-1"></i>
                                            {{ ucfirst($material->type) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Download Button -->
                            <div class="col-md-4 mt-3 mt-md-0">
                                @if ($material->file_path)
                                    <div class="d-flex justify-content-md-end">
                                        <a href="{{ asset($material->file_path) }}"
                                            class="btn btn-primary px-4 py-2 shadow-sm"
                                            download="{{ $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION) }}">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-download me-2"></i>
                                                <div>
                                                    <div class="fw-medium">Download</div>
                                                    <div class="extra-small text-white-50">
                                                        {{ strtoupper(pathinfo($material->file_path, PATHINFO_EXTENSION)) }}
                                                        File</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Description Section -->
                        @if ($material->description)
                            <div class="mb-4">
                                <h5 class="text-primary mb-3">Description</h5>
                                <div class="border rounded p-3 bg-light">
                                    {{ $material->description }}
                                </div>
                            </div>
                        @endif

                        <!-- Main Content Preview Section -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">Content Preview</h5>

                            @if ($material->type == 'text')
                                <div class="border rounded p-4 bg-white">
                                    {!! $material->content !!}
                                </div>
                            @elseif($material->type == 'image' && $material->file_path)
                                <div class="border rounded overflow-hidden bg-light">
                                    <img src="{{ asset($material->file_path) }}" alt="{{ $material->title }}"
                                        class="img-fluid w-100 d-block" style="max-height: 70vh; object-fit: contain;">
                                </div>
                            @elseif($material->type == 'video' && $material->file_path)
                                <div class="border rounded overflow-hidden bg-light">
                                    <div class="ratio ratio-16x9">
                                        <video controls class="w-100">
                                            <source src="{{ asset($material->file_path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                            @elseif($material->type == 'document' && $material->file_path)
                                @php
                                    $extension = pathinfo($material->file_path, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($extension, ['pdf']))
                                    <div class="border rounded overflow-hidden bg-light" style="height: 80vh;">
                                        <iframe src="{{ asset($material->file_path) }}#toolbar=0&view=fitH"
                                            class="w-100 h-100 border-0" frameborder="0"></iframe>
                                    </div>
                                @elseif(in_array($extension, ['doc', 'docx', 'ppt', 'pptx']))
                                    <div class="border rounded p-4 bg-light text-center">
                                        <div class="py-4">
                                            <i class="fas fa-file-word fa-5x text-primary mb-3"></i>
                                            <h5>Document Preview</h5>
                                            <p class="text-muted mb-4">For best viewing experience, please use the online
                                                viewer</p>
                                            <a href="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode(asset($material->file_path)) }}"
                                                target="_blank" class="btn btn-primary btn-lg">
                                                <i class="fas fa-external-link-alt mr-2"></i> View in Office Online
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="border rounded p-4 bg-light text-center">
                                        <div class="py-4">
                                            <i class="fas fa-file fa-5x text-secondary mb-3"></i>
                                            <h5>File Preview Not Available</h5>
                                            <p class="text-muted mb-4">Download the file to view its contents</p>
                                            <a href="{{ asset($material->file_path) }}" class="btn btn-primary btn-lg"
                                                download>
                                                <i class="fas fa-download mr-2"></i> Download File
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="border rounded p-4 bg-light text-center">
                                    <div class="py-4">
                                        <i class="fas fa-file-alt fa-5x text-muted mb-3"></i>
                                        <h5>No Preview Available</h5>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                            <a href="{{ route('materials.edit', $material->id) }}" class="btn btn-warning px-4">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <form action="{{ route('materials.destroy', $material->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger px-4"
                                    onclick="return confirm('Are you sure you want to delete this material?')">
                                    <i class="fas fa-trash mr-2"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        }

        .card-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        .badge {
            font-size: 0.85em;
            font-weight: 500;
            padding: 0.5em 0.8em;
            color: #fff;
        }

        iframe {
            background: white;
        }

        .file-preview-container {
            min-height: 70vh;
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .material-title {
            font-weight: 600;
            color: #2c3e50;
        }

        .btn-action {
            min-width: 120px;
        }

        @media (max-width: 768px) {
            .header-info {
                flex-direction: column;
            }

            .header-actions {
                margin-top: 1rem;
                align-self: flex-start !important;
            }
        }



        .avatar-sm {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-title {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .badge.rounded-pill {
            font-size: 14px;
            font-weight: 500;
            padding: 0.5em 1em;
            display: inline-flex;
            align-items: center;
        }

        .extra-small {
            font-size: 0.7rem;
            line-height: 1.2;
        }
    </style>
@endpush
