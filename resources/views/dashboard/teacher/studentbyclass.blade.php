@extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-2">
                            <i class="fas fa-users me-2"></i>Students in {{ $classLevel->name }}
                        </h2>

                        <p class="text-muted mb-0">
                            <i class="fas fa-school me-1"></i> {{ $branch->branch_name }} Branch
                        </p>
                    </div>
                    <div class="d-flex">
                        <div class="me-3">
                            <span class="badge bg-info rounded-pill fs-6 p-2">
                                <i class="fas fa-user-graduate me-1"></i> {{ $students->count() }} Students
                            </span>
                        </div>
                        {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            <i class="fas fa-plus me-1"></i> Add Student
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="studentsTable" class="table table-hover align-middle mb-0" style="width:100%">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Student</th>
                                        <th>School</th>
                                        <th>Medium</th>
                                        <th>Class</th>
                                        <th width="120">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $index => $student)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        @if ($student->image)
                                                            <img src="{{ asset('storage/' . $student->image) }}"
                                                                class="rounded-circle border" width="40" height="40"
                                                                alt="{{ $student->name }}">
                                                        @else
                                                            <div class="avatar-placeholder rounded-circle bg-light text-center d-flex align-items-center justify-content-center"
                                                                style="width:60px; height:60px;">
                                                                <i class="fas fa-user text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0">{{ $student->name }}</h6>
                                                        <small class="text-muted">ID: {{ $student->stu_id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $student->school_name ?? '-' }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $student->medium == 'english' ? 'info' : 'warning' }}">
                                                    {{ ucfirst($student->medium) }}
                                                </span>
                                            </td>
                                            <td>{{ $classLevel->name }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary objection-btn"
                                                    data-student-id="{{ $student->stu_id }}" data-bs-toggle="modal"
                                                    data-bs-target="#objectionModal">
                                                    <i class="fas fa-edit"></i> Objection
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Objection Modal -->
    <div class="modal fade" id="objectionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Create Objection</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="objectionForm" method="POST" action="{{ route('teacher.objections.store') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="student_id" id="student_id">
                        <input type="hidden" name="class_level_id" value="{{ $classLevel->id }}">
                        <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                        <input type="hidden" name="teacher_id" value="{{ auth()->user()->unique_id }}">

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Objection</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .card {
            border: none;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        }

        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        .avatar-placeholder {
            border: 1px dashed #dee2e6;
        }

        .page-header {
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
        }

        .badge.bg-info {
            background-color: #0dcaf0 !important;
        }

        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #212529;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#studentsTable').DataTable({
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search students...",
                    lengthMenu: "Show _MENU_ students per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ students",
                    infoEmpty: "No students found",
                    zeroRecords: "No matching students found"
                },
                columnDefs: [{
                        orderable: false,
                        targets: [5]
                    },
                    {
                        searchable: false,
                        targets: [0, 5]
                    }
                ],
                dom: '<"top"<"row"<"col-md-6"l><"col-md-6"f>>>rt<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
                initComplete: function() {}
            });

            // Handle objection button click
            $(document).on('click', '.objection-btn', function() {
                const studentId = $(this).data('student-id');
                $('#student_id').val(studentId);
            });

            // Handle form submission
            $('#objectionForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#objectionModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Objection submitted successfully!',
                            timer: 2000
                        });
                        $('#objectionForm')[0].reset();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON.message ||
                                'Failed to submit objection'
                        });
                    }
                });
            });
        });
    </script>
@endpush
