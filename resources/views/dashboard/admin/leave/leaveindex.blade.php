@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Leave Applications</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Applicant</th>
                                    <th>Type</th>
                                    <th>Dates</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                <tr>
                                    <td>{{ $application->user_name }}</td>
                                    <td>{{ ucfirst($application->type) }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($application->start_date)->format('M d, Y') }} - 
                                        {{ \Carbon\Carbon::parse($application->end_date)->format('M d, Y') }}
                                    </td>
                                    <td>{{ Str::limit($application->reason, 50) }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $application->status == 'approved' ? 'success' : 
                                            ($application->status == 'rejected' ? 'danger' : 'warning') 
                                        }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                            data-bs-target="#applicationModal{{ $application->id }}">
                                            Review
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals should be placed here, outside of any containers -->
@foreach($applications as $application)
<div class="modal fade" id="applicationModal{{ $application->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Leave Application Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.leave.update', $application->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p><strong>Applicant:</strong> {{ $application->user_name}}</p>
                    <p><strong>Dates:</strong> {{ \Carbon\Carbon::parse($application->start_date)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($application->end_date)->format('M d, Y') }}</p>
                    <p><strong>Reason:</strong> {{ $application->reason }}</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Admin Comment</label>
                        <textarea class="form-control" name="admin_comment" rows="3">{{ $application->admin_comment }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Debugging code - can be removed after confirming it works
    $(document).ready(function() {
        console.log('Document ready');
        $('[data-bs-toggle="modal"]').on('click', function() {
            console.log('Modal button clicked:', $(this).data('bs-target'));
        });
    });
</script>
@endpush