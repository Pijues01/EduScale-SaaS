@extends('dashboard.layout.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }

            .btn {
                padding: 6px 10px;
                font-size: 14px;
            }

            h2 {
                font-size: 22px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Manage Notices</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table id="noticesTable" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Notice Short Description</th>
                        <th>Notice</th>
                        <th>Role</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notices as $notice)
                        <tr>
                            <td>{{ $notice->id }}</td>
                            <td>{{ $notice->title }}</td>
                            <td>{{ $notice->shortdescription }}</td>
                            <td>{{ $notice->description }}</td>
                            <td>{{ implode(', ', $notice->audience) }}</td>
                            <td>{{ $notice->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('notices.edit', $notice->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button class="btn btn-sm btn-danger deleteNotice"
                                    data-id="{{ $notice->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#noticesTable').DataTable({
                responsive: true
            });

            $('.deleteNotice').on('click', function() {
                let id = $(this).data('id');
                if (confirm('Are you sure you want to delete this notice?')) {
                    $.ajax({
                        url: '/admin/notices/delete/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // alert(response.success);
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush
