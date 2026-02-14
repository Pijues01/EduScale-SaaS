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
        <h2 class="mb-4 text-center">Notices</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table id="noticesTable" class="table table-bordered table-striped">
                <thead class="table-dark">
    <tr>
        <th>Title</th>
        <th>Short Description</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
</thead>

                <tbody>
                    @foreach ($notices as $notice)
                        <tr onclick="window.location='{{ route('student.noticeview', $notice->id) }}'" style="cursor:pointer;">
                            <td>{{ $notice->title }}</td>
                            <td>{{ $notice->shortdescription }}</td>
                            <td>{{ $notice->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('student.noticeview', $notice->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
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
        });
    </script>
@endpush
