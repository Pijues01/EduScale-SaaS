@extends('dashboard.layout.master')

@section('title', 'My Study Materials')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">My Study Materials1111</h4>
                        <a href="{{ route('materials.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus mr-1"></i> Add New
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="materials-table" class="table table-hover table-bordered w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Teacher Name</th>
                                    <th>Type</th>
                                    <th>Upload Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materials as $material)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $material->title }}</td>
                                    <td>{{ $material->teacher_name }}</td>
                                    <td>
                                        <span class="badge
                                            @if($material->type == 'document') bg-info
                                            @elseif($material->type == 'video') bg-primary
                                            @elseif($material->type == 'image') bg-success
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($material->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $material->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('student.materials.show', $material->id) }}"
                                               class="btn btn-sm btn-info mr-2"
                                               title="View">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                        </div>
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
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
<style>
    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
    }
    .card-header {
        border-bottom: none;
    }
    .badge {
        font-size: 0.85em;
        font-weight: 500;
        padding: 0.35em 0.65em;
        color:rgb(255, 255, 255);
    }
    .table thead th {
        border-bottom: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#materials-table').DataTable({
            responsive: true,
            order: [[4, 'desc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search materials...",
                lengthMenu: "Show _MENU_ materials per page",
                info: "Showing _START_ to _END_ of _TOTAL_ materials",
                infoEmpty: "No materials found",
                infoFiltered: "(filtered from _MAX_ total materials)"
            },
            columnDefs: [
                { responsivePriority: 1, targets: 1 }, // Title
                { responsivePriority: 2, targets: -1 }, // Actions
                { orderable: false, targets: -1 } // Disable sorting on actions column
            ]
        });
    });
</script>
@endpush
