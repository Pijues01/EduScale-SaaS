
@extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">My Children's Objections</h4>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (empty($childIds))
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        No children are associated with your account.
                    </div>
                @elseif($objections->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No objections found for your children.
                    </div>
                @else
                    @foreach ($childIds as $childId)
                        @php
                            $childObjections = $objections->where('student_id', $childId);
                            $child = $objections->firstWhere('student_id', $childId)?->student;
                        @endphp

                        @if ($child && $childObjections->isNotEmpty())
                            <div class="child-section mb-5 border-bottom pb-4">
                                <div class="d-flex align-items-center mb-3">
                                    @if ($child->image)
                                        <img src="{{ asset('storage/' . $child->image) }}" class="rounded-circle me-3"
                                            width="50" height="50" alt="{{ $child->name }}"
                                            onerror="this.src='{{ asset('blank-profile.png') }}'">
                                    @else
                                        <img src="{{ asset('blank-profile.png') }}" class="rounded-circle me-3"
                                            width="50" height="50" alt="Default student image">
                                    @endif
                                    <div>
                                        <h5 class="mb-0">{{ $child->name }}</h5>
                                        <p class="text-muted mb-0">Student ID: {{ $child->stu_id }}</p>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Class</th>
                                                <th>Branch</th>
                                                <th>Send By</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($childObjections as $objection)
                                                <tr>
                                                    <td>{{ $objection->classLevel->name ?? 'N/A' }}</td>
                                                    <td>{{ $objection->branch->branch_name ?? 'N/A' }}</td>
                                                    <td>
                                                        @isset($objection->teacher->name)
                                                            Teacher: {{ $objection->teacher->name }}
                                                        @else
                                                            Director
                                                        @endisset
                                                    </td>
                                                    <td>{{ $objection->title }}</td>
                                                    <td>
                                                        @if ($objection->approved)
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-circle me-1"></i> Approved
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">
                                                                <i class="fas fa-clock me-1"></i> Pending
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $objection->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info view-details"
                                                            data-bs-toggle="modal" data-bs-target="#objectionDetailsModal"
                                                            data-title="{{ $objection->title }}"
                                                            data-description="{{ $objection->description }}"
                                                            data-date="{{ $objection->created_at->format('M d, Y h:i A') }}"
                                                            data-status="{{ $objection->approved ? 'Approved' : 'Pending' }}"
                                                            data-sender="{{ $objection->teacher ? 'Teacher: ' . $objection->teacher->name : 'Director' }}"
                                                            data-student-name="{{ $child->name }}"
                                                            data-student-id="{{ $child->stu_id }}"
                                                            data-class="{{ $objection->classLevel->name ?? 'N/A' }}"
                                                            data-branch="{{ $objection->branch->branch_name ?? 'N/A' }}"
                                                            aria-label="View objection details for {{ $objection->title }}">
                                                            <i class="fas fa-eye me-1"></i> Details
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Objection Details Modal -->
    <div class="modal fade" id="objectionDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="objectionDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h2 class="modal-title h5" id="objectionDetailsModalLabel">Objection Details</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Status:</strong> <span id="detailsModalStatus" class="badge"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date Submitted:</strong> <span id="detailsModalDate"></span></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Send By:</strong> <span id="detailsModalSender"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Student:</strong> <span id="detailsModalStudent"></span></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Class:</strong> <span id="detailsModalClass"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Branch:</strong> <span id="detailsModalBranch"></span></p>
                        </div>
                    </div>
                    <hr>
                    <h3 class="h6 mb-2">Title:</h3>
                    <p class="mb-3" id="detailsModalTitleText"></p>

                    <h3 class="h6 mb-2">Description:</h3>
                    <div class="border p-3 rounded bg-light">
                        <p id="detailsModalDescription" class="mb-0"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            console.log('Document ready, setting up modal handlers');
            
            // View details modal handler
            $(document).on('click', '.view-details', function(e) {
                e.preventDefault();
                const $button = $(this);
                
                // Debug: Log all data attributes
                console.log('Button clicked, data attributes:', {
                    title: $button.data('title'),
                    description: $button.data('description'),
                    date: $button.data('date'),
                    status: $button.data('status'),
                    sender: $button.data('sender'),
                    studentName: $button.data('student-name'),
                    studentId: $button.data('student-id'),
                    class: $button.data('class'),
                    branch: $button.data('branch')
                });

                // Set modal content from data attributes
                $('#objectionDetailsModalLabel').text('Objection: ' + $button.data('title'));
                $('#detailsModalTitleText').text($button.data('title'));
                $('#detailsModalDescription').text($button.data('description'));
                $('#detailsModalDate').text($button.data('date'));
                $('#detailsModalSender').text($button.data('sender'));
                $('#detailsModalStudent').text($button.data('student-name') + ' (ID: ' + $button.data('student-id') + ')');
                $('#detailsModalClass').text($button.data('class'));
                $('#detailsModalBranch').text($button.data('branch'));

                // Set status badge
                const $statusBadge = $('#detailsModalStatus');
                $statusBadge.text($button.data('status'));
                $statusBadge.removeClass('bg-success bg-warning')
                    .addClass($button.data('status') === 'Approved' ? 'bg-success' : 'bg-warning');
                
                console.log('Modal data set successfully');
            });

            // Focus management for accessibility
            $('#objectionDetailsModal').on('shown.bs.modal', function() {
                console.log('Modal shown');
                $(this).find('.btn-secondary').focus();
            });

            $('#objectionDetailsModal').on('hidden.bs.modal', function() {
                $('.view-details:focus').focus();
            });
        });
    </script>
@endpush

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .child-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .table {
            font-size: 0.9rem;
        }

        .table th {
            font-weight: 600;
            background-color: #f1f1f1 !important;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.35em 0.65em;
            font-weight: 500;
        }

        .badge i {
            font-size: 0.9em;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        .modal-body p {
            margin-bottom: 0.5rem;
        }

        /* Ensure proper heading hierarchy in modal */
        .modal-title {
            font-size: 1.25rem;
        }
    </style>
@endpush
