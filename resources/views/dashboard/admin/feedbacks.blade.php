@extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-inbox me-2"></i>Feedback Management</h5>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="filterDropdown"
                            data-bs-toggle="dropdown">
                            Filter: {{ ucfirst(request('filter', 'all')) }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?filter=all">All</a></li>
                            <li><a class="dropdown-item" href="?filter=pending">Pending</a></li>
                            <li><a class="dropdown-item" href="?filter=resolved">Resolved</a></li>
                            <li><a class="dropdown-item" href="?filter=rejected">Rejected</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>From</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Branch</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- In resources/views/admin/feedbacks.blade.php -->
                            @forelse($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $feedback->created_at->format('d M Y') }}</td>
                                    <td>
                                        {{ $feedback->user ? $feedback->user->name : 'Deleted User' }}
                                        ({{ ucfirst($feedback->role_type) }})
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $feedback->type == 'objection' ? 'danger' : 'primary' }}">
                                            {{ ucfirst($feedback->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $feedback->title }}</td>
                                    <td>
                                        {{ $feedback->branch ? $feedback->branch->branch_name : 'N/A' }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $feedback->status == 'resolved' ? 'success' : 'warning' }}">
                                            {{ ucfirst($feedback->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary view-feedback" data-bs-toggle="modal"
                                            data-bs-target="#feedbackModal" data-title="{{ $feedback->title }}"
                                            data-description="{{ $feedback->description }}"
                                            data-status="{{ $feedback->status }}"
                                            data-notes="{{ $feedback->admin_notes }}" data-id="{{ $feedback->id }}">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No feedback submissions found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $feedbacks->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="updateFeedbackForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Description:</label>
                            <p id="modalDescription" class="p-2 bg-light rounded"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status:</label>
                            <select class="form-select" name="status" id="modalStatus">
                                <option value="pending">Pending</option>
                                <option value="resolved">Resolved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Notes:</label>
                            <textarea class="form-control" name="admin_notes" id="modalNotes" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.view-feedback').click(function() {
                const title = $(this).data('title');
                const description = $(this).data('description');
                const status = $(this).data('status');
                const notes = $(this).data('notes');
                const id = $(this).data('id');

                $('#modalTitle').text(title);
                $('#modalDescription').text(description);
                $('#modalStatus').val(status);
                $('#modalNotes').val(notes || '');

                $('#updateFeedbackForm').attr('action', '/admin/feedbacks/' + id);
            });
        });
    </script>
@endpush
