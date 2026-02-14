@extends('dashboard.layout.master')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Job Applications</h2>

        <div class="table-responsive">
            <table id="applicationsTable" class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Job Title</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Resume</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <td>{{ $application->id }}</td>
                            <td>{{ $application->job->title }}</td>
                            <td>{{ $application->name }}</td>
                            <td>{{ $application->email }}</td>
                            <td>{{ $application->phone }}</td>
                            <td>{{ $application->message }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $application->resume) }}" target="_blank"
                                    class="btn btn-info btn-sm">View</a>
                                <a href="{{ asset('storage/' . $application->resume) }}" download
                                    class="btn btn-success btn-sm">Download</a>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm"
                                    onclick="deleteApplication({{ $application->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <!-- Include jQuery and DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#applicationsTable').DataTable();
        });

        function deleteApplication(id) {
            if (confirm("Are you sure you want to delete this application?")) {
                $.ajax({
                    url: "{{ route('admin.application.delete', '') }}/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        }
    </script>
@endpush
