
{{--
@extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Dashboard of Parent</h1>
        {{ auth()->user()->name }}
        {{ auth()->user()->unique_id }}
    </div>
@endsection --}}

@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Parent Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Children Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                My Children</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $childrenCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-child fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notices Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                New Notices</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $newobjectionCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bell fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Child Attendance (This Month)</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $attendancePercentage ?? 0 }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: {{ $attendancePercentage ?? 0 }}%"
                                             aria-valuenow="{{ $attendancePercentage ?? 0 }}"
                                             aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Upcoming Events</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $upcomingEventsCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Children Summary -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">My Children Summary</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                             aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('parent.children') }}">View All</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Attendance</th>
                                    <th>Last Notice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($children as $child)
                                <tr>
                                    <td>{{ $child->name }}</td>
                                    <td>{{ $child->class }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                 style="width: {{ $child->attendance }}%"
                                                 aria-valuenow="{{ $child->attendance }}"
                                                 aria-valuemin="0" aria-valuemax="100">
                                                {{ $child->attendance }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($child->last_notice)
                                            {{ $child->last_notice->created_at->diffForHumans() }}
                                            <span class="badge badge-{{ $child->last_notice->is_important ? 'danger' : 'info' }}">
                                                {{ $child->last_notice->is_important ? 'Important' : 'Regular' }}
                                            </span>
                                        @else
                                            No notices
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No children registered</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Notices -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Notices</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                             aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('parent.notices') }}">View All</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    @forelse($recentNotices as $notice)
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-bold text-{{ $notice->is_important ? 'danger' : 'primary' }}">
                                {{ $notice->title }}
                            </h6>
                            <small class="text-muted">{{ $notice->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ Str::limit($notice->content, 100) }}</p>
                        @if($notice->attachment)
                        <a href="{{ Storage::url($notice->attachment) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-paperclip"></i> Attachment
                        </a>
                        @endif
                        <hr>
                    </div>
                    @empty
                    <p class="text-muted">No recent notices</p>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Holidays -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Upcoming Holidays</h6>
                </div>
                <div class="card-body">
                    @forelse($upcomingHolidays as $holiday)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $holiday->title }}</strong>
                            <span class="badge badge-primary">{{ $holiday->date->format('M d') }}</span>
                        </div>
                        <small class="text-muted">{{ $holiday->description }}</small>
                        <hr>
                    </div>
                    @empty
                    <p class="text-muted">No upcoming holidays</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('parent.children') }}" class="btn btn-primary m-2">
                        <i class="fas fa-child fa-fw"></i> View Children
                    </a>
                    <a href="{{ route('parent.notices') }}" class="btn btn-success m-2">
                        <i class="fas fa-bell fa-fw"></i> View Notices
                    </a>
                    <a href="{{ route('parent.objections') }}" class="btn btn-warning m-2">
                        <i class="fas fa-exclamation-circle fa-fw"></i> Submit Objection
                    </a>
                    <a href="{{ route('parent.feedback') }}" class="btn btn-info m-2">
                        <i class="fas fa-comment fa-fw"></i> Provide Feedback
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .progress {
        height: 1rem;
        border-radius: 0.35rem;
    }
    .progress-bar {
        border-radius: 0.35rem;
    }
    .badge {
        font-size: 0.75em;
        font-weight: 600;
        padding: 0.35em 0.65em;
    }
</style>
@endpush
