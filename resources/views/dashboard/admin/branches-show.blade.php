@extends('dashboard.layout.master')
@push('css')
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush
@section('content')
<div class="container">
    <h2>Branches</h2>
    <a href="{{ route('admin.branches.create') }}" class="btn btn-primary mb-3">Add Branch</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table id="branchesTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Branch Name</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($branches as $branch)
                <tr>
                    <td>{{ $branch->id }}</td>
                    <td>{{ $branch->branch_name }}</td>
                    <td>{{ $branch->location }}</td>
                    <td>
                        <a href="{{ route('admin.branches.edit', $branch->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.branches.delete', $branch->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<!-- DataTables & jQuery CDN -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#branchesTable').DataTable({
            responsive: true, // Enable responsiveness
            autoWidth: false, // Prevent width issues
            paging: true, // Enable pagination
            searching: true, // Enable search box
            ordering: true, // Enable sorting
            info: true, // Show info (e.g., "Showing 1 to 10 of 50 entries")
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]], // Entries per page
        });
    });
</script>
@endpush
