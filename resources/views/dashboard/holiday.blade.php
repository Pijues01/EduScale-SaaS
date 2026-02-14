@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header pb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Holiday Calendar</h5>
                            <p class="text-sm mb-0">All scheduled holidays at a glance</p>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>

                @php
                    $route = auth()->user()->role == 'teacher'
                        ? route('teacher.holidays.index')
                        : (auth()->user()->role == 'student'
                        ? route('student.holidays.index')
                        : route('parent.holidays.index'));
                @endphp

                <!-- Holiday List -->
                <div class="card-body px-0 pt-0 pb-2">
                    @if(request()->hasAny(['start_date', 'end_date', 'branch_id', 'is_recurring']))
                    <div class="alert alert-info alert-dismissible fade show mx-3" role="alert">
                        <strong>Filters Applied:</strong>
                        @if(request('start_date')) From: {{ request('start_date') }} @endif
                        @if(request('end_date')) To: {{ request('end_date') }} @endif
                        @if(request('branch_id')) | Branch: {{ \App\Models\Branch::find(request('branch_id'))->branch_name ?? 'All' }} @endif
                        @if(request('is_recurring') !== null) | Type: {{ request('is_recurring') ? 'Recurring' : 'One-time' }} @endif
                        {{-- <a href="@if ({{ auth()->user()->role }} == 'teacher'){{ route('teacher.holidays.index') }}@elseif ({{ auth()->user()->role }} == 'student'){{ route('student.holidays.index') }}@else{{ route('parent.holidays.index') }}@endif"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a> --}}
                        {{-- <a href="@if(auth()->user()->role == 'teacher'){{ route('teacher.holidays.index') }}@elseif(auth()->user()->role == 'student'){{ route('student.holidays.index') }}@else{{ route('parent.holidays.index') }}@endif">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</a> --}}
                        <a href="{{ $route }}">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </a>
                    </div>
                    @endif

                    <div class="table-responsive p-3">
                        <table class="table table-hover align-items-center">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder">Date</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder ps-3">Title</th>
                                    {{-- <th class="text-uppercase text-secondary text-xs font-weight-bolder">Description</th> --}}
                                    {{-- <th class="text-uppercase text-secondary text-xs font-weight-bolder">Recurring</th> --}}
                                    {{-- <th class="text-uppercase text-secondary text-xs font-weight-bolder">Branch</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($holidays as $holiday)
                                <tr class="border-bottom">
                                     <td>
                                        <span class="text-sm font-weight-bold">{{ $holiday->date->format('D, M j, Y') }}</span>
                                        <p class="text-xs text-muted mb-0">
                                            @if($holiday->date->isToday())
                                                <span class="badge bg-info">Today</span>
                                            @elseif($holiday->date->isFuture())
                                                <span class="badge bg-success">{{ $holiday->date->diffForHumans() }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $holiday->date->diffForHumans() }}</span>
                                            @endif
                                        </p>
                                    </td>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape bg-{{ $holiday->date->isPast() ? 'secondary' : 'primary' }} text-white rounded-circle me-2">
                                                <i class="fas fa-calendar-day"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-sm">{{ $holiday->title }}</h6>
                                                {{-- <p class="text-xs text-muted mb-0">
                                                    Created: {{ $holiday->created_at->format('M d, Y') }}
                                                </p> --}}
                                            </div>
                                        </div>
                                    </td>

                                    {{-- <td>
                                        <p class="text-sm mb-0">
                                            {{ $holiday->description ? Str::limit($holiday->description, 50) : 'No description' }}
                                        </p>
                                    </td> --}}
                                    {{-- <td>
                                        @if($holiday->is_recurring)
                                        <span class="badge bg-success">
                                            <i class="fas fa-sync-alt me-1"></i> Recurring
                                        </span>
                                        @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-calendar-times me-1"></i> One-time
                                        </span>
                                        @endif
                                    </td> --}}
                                    {{-- <td>
                                        <span class="badge bg-gradient-{{ $holiday->branch ? 'info' : 'dark' }}">
                                            {{ $holiday->branch->branch_name ?? 'All Branches' }}
                                        </span>
                                    </td> --}}
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-calendar-times fa-3x text-muted mb-2"></i>
                                            <h6 class="text-muted">No holidays found matching your criteria</h6>
                                            {{-- <a href="{{ route('teacher.holidays.index') }}" class="btn btn-sm btn-primary mt-2">
                                                Reset Filters
                                            </a> --}}
                                            <a href="{{ $route }}" class="btn btn-sm btn-primary mt-2">
                                                Reset Filters
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($holidays->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div class="text-muted text-sm">
                            Showing {{ $holidays->firstItem() }} to {{ $holidays->lastItem() }} of {{ $holidays->total() }} entries
                        </div>
                        <div>
                            {{ $holidays->withQueryString()->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Holidays</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form method="GET" action="{{ route('teacher.holidays.index') }}"> --}}
            <form method="GET" action="{{ $route }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Date Range</label>
                        <div class="input-daterange input-group">
                            <input type="date" class="form-control" name="start_date" placeholder="Start Date"
                                   value="{{ request('start_date') }}" autocomplete="off">
                            <span class="input-group-text">to</span>
                            <input type="date" class="form-control" name="end_date" placeholder="End Date"
                                   value="{{ request('end_date') }}" autocomplete="off">
                        </div>
                    </div>
                    @if (auth()->user()->role == 'teacher')
                        <div class="mb-3">
                            <label class="form-label">Branch</label>
                            <select class="form-select" name="branch_id">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->branch_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3 d-none">
                        <label class="form-label">Recurring Status</label>
                        <select class="form-select" name="is_recurring">
                            <option value="">All Types</option>
                            <option value="1" {{ request('is_recurring') == '1' ? 'selected' : '' }}>Recurring Only</option>
                            <option value="0" {{ request('is_recurring') == '0' ? 'selected' : '' }}>One-time Only</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    {{-- <a href="{{ route('teacher.holidays.index') }}" class="btn btn-outline-danger ms-2">Reset All</a> --}}
                    <a href="{{ $route }}" class="btn btn-outline-danger ms-2">Reset All</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    .alert {
        margin-bottom: 1rem;
    }
</style>
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
<script>
    $(document).ready(function() {
        // Close alert
        $('.alert .btn-close').click(function() {
            $(this).parent().alert('close');
        });
    });
</script>
@endpush
