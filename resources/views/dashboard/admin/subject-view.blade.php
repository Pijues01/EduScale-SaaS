@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg rounded-3 border-0">
                <div class="card-header bg-primary text-white rounded-top-3 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-book me-2"></i>All Subjects</h4>
                        <a href="{{ route('admin.addsubject') }}" class="btn btn-light btn-sm rounded-pill">
                            <i class="fas fa-plus me-1"></i> Add New Subject
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="subjectsTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Subject Name</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Updated At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $subject)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-book text-primary me-2"></i>
                                            <span>{{ $subject->sub_name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $subject->created_at->format('d M Y') }}</td>
                                    <td class="text-center">{{ $subject->updated_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.subject.update', $subject->id) }}"
                                               class="btn btn-sm btn-outline-primary rounded-start-pill"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.subject.delete', $subject->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-end-pill"
                                                        onclick="return confirm('Are you sure you want to delete this subject?')"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No Subjects Found</h5>
                                            <a href="{{ route('admin.addsubject') }}" class="btn btn-primary mt-2 rounded-pill">
                                                <i class="fas fa-plus me-1"></i> Add First Subject
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- @if($subjects->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $subjects->links() }}
                    </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<style>
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .table-hover tbody tr {
        transition: all 0.2s ease;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    .btn-group .btn {
        border-radius: 0;
    }
    .btn-group .btn:first-child {
        border-top-left-radius: 50rem !important;
        border-bottom-left-radius: 50rem !important;
    }
    .btn-group .btn:last-child {
        border-top-right-radius: 50rem !important;
        border-bottom-right-radius: 50rem !important;
    }
</style>
@endpush

@push('js')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        $('#subjectsTable').DataTable({
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [4] }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search subjects...",
                emptyTable: "No subjects available in table",
                zeroRecords: "No matching subjects found"
            }
        });

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
