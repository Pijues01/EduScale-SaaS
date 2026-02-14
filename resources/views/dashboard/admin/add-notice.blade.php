@extends('dashboard.layout.master')

@section('content')
    {{-- <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add a Notice</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('notice.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Notice Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Notice Title</label>
                        <input type="text" class="form-control" id="title" name="title" required
                            placeholder="Enter notice title">
                    </div>

                    <!-- Notice Description -->
                    <div class="mb-3">
                        <label for="shortdescription" class="form-label">Notice Short Description</label>
                        <textarea class="form-control" id="shortdescription" name="shortdescription" rows="2" required
                            placeholder="Write short notice details..."></textarea>
                    </div>

                    <!-- Notice Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Notice</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required
                            placeholder="Write notice details..."></textarea>
                    </div>

                    <!-- Audience Selection -->
                    <div class="mb-3">
                        <label class="form-label">Target Audience</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="audience[]" value="students"
                                id="students">
                            <label class="form-check-label" for="students">Students</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="audience[]" value="parents"
                                id="parents">
                            <label class="form-check-label" for="parents">Parents</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="audience[]" value="teachers"
                                id="teachers">
                            <label class="form-check-label" for="teachers">Teachers</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="audience[]" value="general"
                                id="general">
                            <label class="form-check-label" for="general">General</label>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-3">
                        <label for="attachment" class="form-label">Attach File (optional)</label>
                        <input type="file" class="form-control" id="attachment" name="attachment"
                            accept=".pdf, .jpg, .png">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success w-100">Publish Notice</button>
                </form>
            </div>
        </div>
    </div> --}}


    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ isset($notice) ? 'Edit Notice' : 'Add a Notice' }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ isset($notice) ? route('notice.update', $notice->id) : route('notice.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($notice))
                        @method('PUT')
                    @endif

                    <!-- Notice Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Notice Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ old('title', $notice->title ?? '') }}" required placeholder="Enter notice title">
                    </div>

                    <!-- Notice Short Description -->
                    <div class="mb-3">
                        <label for="shortdescription" class="form-label">Notice Short Description</label>
                        <textarea class="form-control" id="shortdescription" name="shortdescription" rows="2" required
                            placeholder="Write short notice details...">{{ old('shortdescription', $notice->shortdescription ?? '') }}</textarea>
                    </div>

                    <!-- Notice Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Notice</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required
                            placeholder="Write notice details...">{{ old('description', $notice->description ?? '') }}</textarea>
                    </div>

                    <!-- Audience Selection -->
                    <div class="mb-3">
                        <label class="form-label">Target Audience</label>
                        @php
                            $selectedAudiences = isset($notice) ? (is_array($notice->audience) ? $notice->audience : json_decode($notice->audience, true)) : [];
                        @endphp
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="audience[]" value="students"
                                id="students" {{ in_array('students', $selectedAudiences ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="students">Students</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="audience[]" value="parents" id="parents"
                                {{ in_array('parents', $selectedAudiences ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="parents">Parents</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="audience[]" value="teachers"
                                id="teachers" {{ in_array('teachers', $selectedAudiences ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="teachers">Teachers</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="audience[]" value="general" id="general"
                                {{ in_array('general', $selectedAudiences ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="general">General</label>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-3">
                        <label for="attachment" class="form-label">Attach File (optional)</label>
                        <input type="file" class="form-control" id="attachment" name="attachment"
                            accept=".pdf, .jpg, .png">
                        @if (isset($notice) && $notice->attachment)
                            <p>Current File: <a href="{{ asset($notice->attachment) }}" target="_blank">View Attachment</a>
                            </p>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success w-100">
                        {{ isset($notice) ? 'Update Notice' : 'Publish Notice' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
