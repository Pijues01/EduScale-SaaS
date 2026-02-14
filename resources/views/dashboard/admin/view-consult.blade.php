@extends('dashboard.layout.master')

@push('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .view-comment {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Consult Requests</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="consultTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Comment</th>
                                <th>Submitted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consults as $consult)
                                <tr>
                                    <td>{{ $consult->id }}</td>
                                    <td>{{ $consult->name }}</td>
                                    <td>{{ $consult->email ?? 'N/A' }}</td>
                                    <td>{{ $consult->phone }}</td>
                                    <td>{{ $consult->subject }}</td>
                                    <td class="view-comment">{{ $consult->comment }}</td>
                                    <td>{{ $consult->created_at->format('d M Y, h:i A') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary view-btn"
                                                data-id="{{ $consult->id }}"
                                                data-name="{{ $consult->name }}"
                                                data-email="{{ $consult->email ?? 'N/A' }}"
                                                data-phone="{{ $consult->phone }}"
                                                data-subject="{{ $consult->subject }}"
                                                data-comment="{{ $consult->comment }}"
                                                data-created="{{ $consult->created_at->format('d M Y, h:i A') }}">
                                            <i class="bi bi-eye"></i> View
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

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="viewModalLabel">Consult Request Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> <span id="view-id"></span></p>
                            <p><strong>Name:</strong> <span id="view-name"></span></p>
                            <p><strong>Email:</strong> <span id="view-email"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phone:</strong> <span id="view-phone"></span></p>
                            <p><strong>Subject:</strong> <span id="view-subject"></span></p>
                            <p><strong>Submitted At:</strong> <span id="view-created"></span></p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Comment:</strong></label>
                        <div class="p-3 bg-light rounded" id="view-comment"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#consultTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [
                    { responsivePriority: 1, targets: 0 }, // ID
                    { responsivePriority: 2, targets: 1 }, // Name
                    { responsivePriority: 3, targets: 7 }, // Actions
                    { responsivePriority: 4, targets: 2 }, // Email
                    { responsivePriority: 5, targets: 3 }, // Phone
                    { responsivePriority: 6, targets: 4 }, // Subject
                    { responsivePriority: 7, targets: 5 }, // Comment
                    { responsivePriority: 8, targets: 6 }  // Submitted At
                ]
            });

            // View button click handler
            $(document).on('click', '.view-btn', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const email = $(this).data('email');
                const phone = $(this).data('phone');
                const subject = $(this).data('subject');
                const comment = $(this).data('comment');
                const created = $(this).data('created');

                $('#view-id').text(id);
                $('#view-name').text(name);
                $('#view-email').text(email);
                $('#view-phone').text(phone);
                $('#view-subject').text(subject);
                $('#view-comment').text(comment);
                $('#view-created').text(created);

                // Show the modal
                const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
                viewModal.show();
            });
        });
    </script>
@endpush
