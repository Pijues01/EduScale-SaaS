@extends('dashboard.layout.master')

@section('title', 'My Study Materials')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">My Study Materials</h4>
                        <a href="{{ route('materials.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Material
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Class</th>
                                    <th>Type</th>
                                    <th>Upload Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materials as $material)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $material->title }}</td>
                                    <td>{{ $material->class->name }}</td>
                                    <td>
                                        <span class="badge
                                            @if($material->type == 'document') badge-info
                                            @elseif($material->type == 'video') badge-primary
                                            @elseif($material->type == 'image') badge-success
                                            @else badge-secondary
                                            @endif">
                                            {{ ucfirst($material->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $material->created_at->format('d M Y, h:i A') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- <a href="{{ route('materials.show', $material->id) }}"
                                               class="btn btn-sm btn-info"
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a> --}}
                                            <a href="{{ route('materials.edit', $material->id) }}"
                                               class="btn btn-sm btn-warning"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('materials.destroy', $material->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this material?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No materials found. <a href="{{ route('materials.create') }}">Create one now</a>.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($materials->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $materials->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .badge {
        font-size: 0.85rem;
        padding: 0.35em 0.65em;
    }
    .btn-group .btn {
        margin-right: 5px;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // DataTable initialization if needed
        $('.table').DataTable({
            responsive: true,
            "order": [[ 4, "desc" ]],
            "columnDefs": [
                { "orderable": false, "targets": [5] }
            ]
        });
    });
</script>
@endpush
