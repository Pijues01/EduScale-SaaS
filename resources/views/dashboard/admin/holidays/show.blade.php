{{-- @extends('dashboard.layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h4>Holiday Details</h4>
                    <a href="{{ route('holidays.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
                </div>
                <div class="card-body px-4 pt-0 pb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title</label>
                                <p class="form-control-static">{{ $holiday->title }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <p class="form-control-static">{{ $holiday->date->format('Y-m-d') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Branch</label>
                                <p class="form-control-static">{{ $holiday->branch->branch_name ?? 'All Branches' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recurring</label>
                                <p class="form-control-static">{{ $holiday->is_recurring ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <p class="form-control-static">{{ $holiday->description ?? 'No description' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('holidays.edit', $holiday) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('holidays.destroy', $holiday) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

{{-- @extends('dashboard.layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Holiday Details</h5>
                    <a href="{{ route('holidays.index') }}" class="btn btn-light btn-sm">← Back to List</a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h4 class="text-muted fw-bold">Title</h4>
                            <p class="fs-6 fw-semibold">{{ $holiday->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <h4 class="text-muted">Date</h4>
                            <p class="fs-6 fw-semibold">{{ $holiday->date->format('F j, Y') }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h4 class="text-muted">Branch</h4>
                            <p class="fs-6 fw-semibold">{{ $holiday->branch->branch_name ?? 'All Branches' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h4 class="text-muted">Recurring</h4>
                            <p class="fs-6 fw-semibold">
                                <span class="badge {{ $holiday->is_recurring ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $holiday->is_recurring ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="text-muted">Description</h4>
                            <p class="fs-6">{{ $holiday->description ?? 'No description provided.' }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('holidays.edit', $holiday) }}" class="btn btn-outline-primary">Edit</a>
                        <form action="{{ route('holidays.destroy', $holiday) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this holiday?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


{{-- @extends('dashboard.layout.master')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
                    <h5 class="mb-0">Holiday Details</h5>
                    <a href="{{ route('holidays.index') }}" class="btn btn-outline-light btn-sm">Back to List</a>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group bg-white p-3 rounded shadow-sm">
                                <label class="fw-bold text-muted mb-1">Title</label>
                                <p class="mb-0 fs-5">{{ $holiday->title }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group bg-white p-3 rounded shadow-sm">
                                <label class="fw-bold text-muted mb-1">Date</label>
                                <p class="mb-0 fs-5">{{ $holiday->date->format('F j, Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group bg-white p-3 rounded shadow-sm">
                                <label class="fw-bold text-muted mb-1">Branch</label>
                                <p class="mb-0 fs-5">{{ $holiday->branch->branch_name ?? 'All Branches' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group bg-white p-3 rounded shadow-sm">
                                <label class="fw-bold text-muted mb-1">Recurring</label>
                                <p class="mb-0 fs-5">
                                    <span class="badge {{ $holiday->is_recurring ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $holiday->is_recurring ? 'Yes' : 'No' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group bg-white p-3 rounded shadow-sm">
                                <label class="fw-bold text-muted mb-1">Description</label>
                                <p class="mb-0 text-dark">{{ $holiday->description ?? 'No description available' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('holidays.edit', $holiday) }}" class="btn btn-primary px-4">Edit Holiday</a>
                        <form action="{{ route('holidays.destroy', $holiday) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4" onclick="return confirm('Are you sure you want to delete this holiday?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .form-group {
        transition: box-shadow 0.2s ease-in-out;
    }
    .form-group:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 1em;
    }
</style>
@endpush --}}


@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Holiday Details</h6>
                        <p class="text-sm mb-0">View comprehensive information about this holiday</p>
                    </div>
                    <a href="{{ route('holidays.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                <div class="card-body px-4 pt-0 pb-2">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-none mb-3">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Basic Information</h6>
                                    <div class="d-flex flex-column">
                                        <div class="mb-3">
                                            <label class="form-label text-sm text-muted mb-0">Title</label>
                                            <p class="mb-0 text-dark font-weight-bold">{{ $holiday->title }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-sm text-muted mb-0">Date</label>
                                            <p class="mb-0 text-dark font-weight-bold">
                                                {{ $holiday->date->format('F j, Y') }}
                                                <span class="badge bg-primary ms-2">
                                                    {{ $holiday->date->isPast() ? 'Passed' : 'Upcoming' }}
                                                </span>
                                            </p>
                                        </div>
                                        <div>
                                            <label class="form-label text-sm text-muted mb-0">Recurring</label>
                                            <p class="mb-0 text-dark font-weight-bold">
                                                @if($holiday->is_recurring)
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-none mb-3">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Additional Details</h6>
                                    <div class="d-flex flex-column">
                                        <div class="mb-3">
                                            <label class="form-label text-sm text-muted mb-0">Branch</label>
                                            <p class="mb-0 text-dark font-weight-bold">
                                                {{ $holiday->branch->branch_name ?? 'All Branches' }}
                                            </p>
                                        </div>
                                        <div>
                                            <label class="form-label text-sm text-muted mb-0">Days Until</label>
                                            <p class="mb-0 text-dark font-weight-bold">
                                                @php
                                                    $daysUntil = now()->diffInDays($holiday->date, false);
                                                @endphp
                                                @if($daysUntil > 0)
                                                    {{ $daysUntil }} day{{ $daysUntil > 1 ? 's' : '' }} from now
                                                @elseif($daysUntil == 0)
                                                    Today
                                                @else
                                                    {{ abs($daysUntil) }} day{{ abs($daysUntil) > 1 ? 's' : '' }} ago
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-none">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Description</h6>
                                    <div class="p-3 bg-gray-100 rounded">
                                        @if($holiday->description)
                                            <p class="mb-0 text-dark">{{ $holiday->description }}</p>
                                        @else
                                            <p class="mb-0 text-muted font-italic">No description provided</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <div class="btn-group">
                                <a href="{{ route('holidays.edit', $holiday) }}" class="btn btn-primary me-2">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('holidays.destroy', $holiday) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this holiday?')">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .form-label {
        font-size: 0.75rem;
    }
    .bg-gray-100 {
        background-color: #f8f9fa;
    }
</style>
@endpush    



