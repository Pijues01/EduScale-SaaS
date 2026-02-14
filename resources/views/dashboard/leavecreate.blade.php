{{-- @extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Apply for Leave</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route(auth()->user()->role . '.leave.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" name="end_date" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Reason</label>
                                <textarea class="form-control" name="reason" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.getElementById('leaveTypeSelect').addEventListener('change', function() {
            if (this.value === 'single') {
                document.getElementById('singleDateField').classList.remove('d-none');
                document.getElementById('dateRangeFields').classList.add('d-none');
            } else {
                document.getElementById('singleDateField').classList.add('d-none');
                document.getElementById('dateRangeFields').classList.remove('d-none');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const leaveTypeSelect = document.getElementById('leaveTypeSelect');
            const singleDateField = document.getElementById('singleDateField');
            const dateRangeFields = document.getElementById('dateRangeFields');

            // Initialize form state
            updateFormFields();

            // Add event listener
            leaveTypeSelect.addEventListener('change', updateFormFields);

            function updateFormFields() {
                if (leaveTypeSelect.value === 'single') {
                    singleDateField.classList.remove('d-none');
                    dateRangeFields.classList.add('d-none');
                    // Clear multiple date fields when switching to single
                    dateRangeFields.querySelectorAll('input').forEach(input => input.value = '');
                } else {
                    singleDateField.classList.add('d-none');
                    dateRangeFields.classList.remove('d-none');
                    // Clear single date field when switching to multiple
                    singleDateField.querySelector('input').value = '';
                }
            }
        });
    </script>
@endpush --}}


@extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">My Leave Applications</h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#leaveApplicationModal">
                                <i class="fas fa-plus me-1"></i> Apply New Leave
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Application Date</th>
                                        <th>Leave Dates</th>
                                        <th>Type</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Admin Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($leaves as $leave)
                                        <tr>
                                            <td>{{ $leave->created_at->format('M d, Y') }}</td>
                                            {{-- <td>
                                        @if ($leave->leave_type == 'single')
                                            {{ $leave->start_date->format('M d, Y') }}
                                        @else
                                            {{ $leave->start_date->format('M d, Y') }} -
                                            {{ $leave->end_date->format('M d, Y') }}
                                            ({{ $leave->start_date->diffInDays($leave->end_date) + 1 }} days)
                                        @endif
                                    </td> --}}
                                            <td>
                                                @if ($leave->leave_type == 'single')
                                                    {{ \Carbon\Carbon::parse($leave->start_date)->format('M d, Y') }}
                                                @else
                                                    @php
                                                        $start = \Carbon\Carbon::parse($leave->start_date);
                                                        $end = \Carbon\Carbon::parse($leave->end_date);
                                                    @endphp
                                                    {{ $start->format('M d, Y') }} - {{ $end->format('M d, Y') }}
                                                    ({{ $start->diffInDays($end) + 1 }} days)
                                                @endif
                                            </td>

                                            <td>{{ ucfirst($leave->leave_type) }}</td>
                                            <td>{{ Str::limit($leave->reason, 30) }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $leave->status == 'approved' ? 'success' : ($leave->status == 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($leave->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $leave->admin_comment ?? '--' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-calendar-times fa-3x text-muted mb-2"></i>
                                                    <h6 class="text-muted">No leave applications found</h6>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $leaves->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Application Modal -->
    {{-- <div class="modal fade" id="leaveApplicationModal" tabindex="-1" aria-labelledby="leaveApplicationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leaveApplicationModalLabel">Apply for Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route(auth()->user()->role . '.leave.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Leave Type</label>
                            <select class="form-select" name="leave_type" id="leaveTypeSelect">
                                <option value="single">Single Day</option>
                                <option value="multiple">Multiple Days</option>
                            </select>
                        </div>

                        <div class="mb-3" id="singleDateField">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="single_date" min="{{ date('Y-m-d') }}"
                                value="{{ old('single_date') }}">
                        </div>

                        <div class="mb-3 d-none" id="dateRangeFields">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" min="{{ date('Y-m-d') }}"
                                        value="{{ old('start_date') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date" min="{{ date('Y-m-d') }}"
                                        value="{{ old('end_date') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reason</label>
                            <textarea class="form-control" name="reason" rows="3" required>{{ old('reason') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <!-- Leave Application Modal -->
    <div class="modal fade" id="leaveApplicationModal" tabindex="-1" aria-labelledby="leaveApplicationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leaveApplicationModalLabel">Apply for Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route(auth()->user()->role . '.leave.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" required min="{{ date('Y-m-d') }}"
                                value="{{ old('start_date') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" required min="{{ date('Y-m-d') }}"
                                value="{{ old('end_date') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reason</label>
                            <textarea class="form-control" name="reason" rows="3" required>{{ old('reason') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
        < script >
            document.addEventListener('DOMContentLoaded', function() {
                const leaveTypeSelect = document.getElementById('leaveTypeSelect');
                const singleDateField = document.getElementById('singleDateField');
                const dateRangeFields = document.getElementById('dateRangeFields');

                // Initialize form based on leave type
                function updateFormFields() {
                    if (leaveTypeSelect.value === 'single') {
                        singleDateField.classList.remove('d-none');
                        dateRangeFields.classList.add('d-none');
                        // Clear multiple date fields
                        dateRangeFields.querySelectorAll('input').forEach(input => input.value = '');
                    } else {
                        singleDateField.classList.add('d-none');
                        dateRangeFields.classList.remove('d-none');
                        // Clear single date field
                        singleDateField.querySelector('input').value = '';
                    }
                }

                // Set initial state
                updateFormFields();

                // Update on change
                leaveTypeSelect.addEventListener('change', updateFormFields);

                // Handle modal show event to reset form
                const leaveModal = document.getElementById('leaveApplicationModal');
                leaveModal.addEventListener('show.bs.modal', function() {
                    leaveTypeSelect.value = 'single';
                    updateFormFields();
                });

                // Format dates before submission
                document.querySelector('#leaveApplicationModal form').addEventListener('submit', function(e) {
                    const leaveType = leaveTypeSelect.value;

                    if (leaveType === 'single') {
                        const dateInput = this.querySelector('input[name="single_date"]');
                        if (dateInput.value) {
                            dateInput.value = new Date(dateInput.value).toISOString().split('T')[0];
                        }
                    } else {
                        const startDateInput = this.querySelector('input[name="start_date"]');
                        const endDateInput = this.querySelector('input[name="end_date"]');

                        if (startDateInput.value) {
                            startDateInput.value = new Date(startDateInput.value).toISOString().split('T')[0];
                        }
                        if (endDateInput.value) {
                            endDateInput.value = new Date(endDateInput.value).toISOString().split('T')[0];
                        }
                    }
                });
            });
    </script>
@endpush

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        .badge.bg-success {
            background-color: #28a745;
        }

        .badge.bg-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge.bg-danger {
            background-color: #dc3545;
        }
    </style>
@endpush
