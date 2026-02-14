@extends('dashboard.layout.master')

{{-- @section('title', 'Holiday Calendar') --}}

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Card Header -->
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Holiday Calendar</h5>
                                <p class="text-sm mb-0">All scheduled holidays at a glance</p>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#filterModal">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Holiday List -->
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-3">
                            <table class="table table-hover align-items-center">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder ps-3">Title</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Date</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Description
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Recurring</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Branch</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($holidays as $holiday)
                                        <tr class="border-bottom">
                                            <td class="ps-3">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="icon icon-shape bg-{{ $holiday->date->isPast() ? 'secondary' : 'primary' }} text-white rounded-circle me-2">
                                                        <i class="fas fa-calendar-day"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-sm">{{ $holiday->title }}</h6>
                                                        <p class="text-xs text-muted mb-0">
                                                            Created: {{ $holiday->created_at->format('M d, Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-sm font-weight-bold">{{ $holiday->date->format('D, M j, Y') }}</span>
                                                <p class="text-xs text-muted mb-0">
                                                    @if ($holiday->date->isToday())
                                                        <span class="badge bg-info">Today</span>
                                                    @elseif($holiday->date->isFuture())
                                                        <span
                                                            class="badge bg-success">{{ $holiday->date->diffForHumans() }}</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ $holiday->date->diffForHumans() }}</span>
                                                    @endif
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-sm mb-0">
                                                    {{ $holiday->description ? Str::limit($holiday->description, 50) : 'No description' }}
                                                </p>
                                            </td>
                                            <td>
                                                @if ($holiday->is_recurring)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-sync-alt me-1"></i> Recurring
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-calendar-times me-1"></i> One-time
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-gradient-{{ $holiday->branch ? 'info' : 'dark' }}">
                                                    {{ $holiday->branch->branch_name ?? 'All Branches' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-calendar-times fa-3x text-muted mb-2"></i>
                                                    <h6 class="text-muted">No holidays scheduled</h6>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($holidays->hasPages())
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <div class="text-muted text-sm">
                                    Showing {{ $holidays->firstItem() }} to {{ $holidays->lastItem() }} of
                                    {{ $holidays->total() }} entries
                                </div>
                                <div>
                                    {{ $holidays->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Holidays</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="GET" action="{{ route('teacher.holidays.index') }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Date Range</label>
                            <div class="input-daterange input-group">
                                <input type="text" class="form-control" name="start_date" placeholder="Start Date"
                                    value="{{ request('start_date') }}" autocomplete="off">
                                <span class="input-group-text">to</span>
                                <input type="text" class="form-control" name="end_date" placeholder="End Date"
                                    value="{{ request('end_date') }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Branch</label>
                            <select class="form-select" name="branch_id">
                                <option value="">All Branches</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Recurring Status</label>
                            <select class="form-select" name="is_recurring">
                                <option value="">All</option>
                                <option value="1" {{ request('is_recurring') === '1' ? 'selected' : '' }}>Recurring
                                    Only</option>
                                <option value="0" {{ request('is_recurring') === '0' ? 'selected' : '' }}>One-time
                                    Only</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('teacher.holidays.index') }}" class="btn btn-outline-danger ms-2">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .icon-shape {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .border-bottom {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
        }

        .bg-gray-100 {
            background-color: #f8f9fa;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
    </style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize datepicker
            $('.input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
@endpush
