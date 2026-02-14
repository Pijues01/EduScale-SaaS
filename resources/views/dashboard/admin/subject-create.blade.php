@extends('dashboard.layout.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg rounded-3 border-0">
                    <div class="card-header bg-primary text-white rounded-top-3 py-3">
                        @if ($subject)
                            <h4 class="mb-0 text-center"><i class="fas fa-book me-2"></i>Edit Subject</h4>
                        @else
                            <h4 class="mb-0 text-center"><i class="fas fa-book me-2"></i>Add New Subject</h4>
                        @endif
                    </div>
                    {{-- <div class="card-header bg-primary text-white rounded-top-3 py-3">
                        <h4 class="mb-0 text-center">
                            <i class="fas fa-book me-2"></i>
                            {{ $subject ? 'Edit Subject' : 'Add New Subject' }}
                        </h4>
                    </div> --}}

                    <div class="card-body p-4">
                        {{-- <form action="{{ route('admin.subject.store') }}" method="POST"> --}}
                        <form
                            action="{{ isset($subject) ? route('admin.subject.edit', $subject->id) : route('admin.subject.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($subject))
                                @method('PUT')
                            @endif


                            <div class="mb-4">
                                <label for="sub_name"
                                    class="form-label fw-bold">{{ $subject ? 'Change Subject Name' : 'Subject Name' }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-book-open text-primary"></i>
                                    </span>
                                    {{-- <input type="text"
                                       class="form-control @error('sub_name') is-invalid @enderror"
                                       id="sub_name"
                                       name="sub_name"
                                       value="@if ($subject){{ $subject->sub_name }}@else{{ old('sub_name') }}@endif"
                                       placeholder="Enter subject name"
                                       required> --}}
                                    <input type="text" class="form-control @error('sub_name') is-invalid @enderror"
                                        id="sub_name" name="sub_name" value="{{ $subject->sub_name ?? old('sub_name') }}"
                                        placeholder="Enter subject name" required>

                                    @error('sub_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <small class="text-muted">Enter the name of the subject (e.g. Mathematics, Science)</small>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                @if ($subject)
                                    <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                        <i class="fas fa-save me-1"></i> Edit Subject
                                    </button>
                                @else
                                    <button type="reset" class="btn btn-outline-secondary me-md-2 px-4 rounded-pill">
                                        <i class="fas fa-undo me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                        <i class="fas fa-save me-1"></i> Save Subject
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .input-group-text {
            transition: all 0.3s ease;
        }

        .form-control:focus+.input-group-text {
            background-color: #e7f1ff;
        }
    </style>
@endpush

@push('js')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to form elements
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.querySelector('.input-group-text').style.transform =
                        'scale(1.05)';
                });
                input.addEventListener('blur', function() {
                    this.parentElement.querySelector('.input-group-text').style.transform =
                        'scale(1)';
                });
            });
        });
    </script>
@endpush
