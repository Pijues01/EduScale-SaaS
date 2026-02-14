
{{-- @extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Dashboard of Student</h1>
        {{ auth()->user()->unique_id }}
    </div>
@endsection --}}


@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Student Dashboard</h1>
        <div class="d-none d-sm-inline-block">
            <span class="badge badge-primary">{{ Auth::user()->class->name ?? 'No Class' }}</span>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Attendance Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Attendance (This Month)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendancePercentage }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $recentNotices->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bell fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Classes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Today's Classes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayClasses->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Holidays Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Upcoming Holidays</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $upcomingHolidays->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-umbrella-beach fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Today's Schedule -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Today's Class Schedule</h6>
                </div>
                <div class="card-body">
                    @if($todayClasses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Room</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayClasses as $class)
                                <tr>
                                    <td>{{ $class->start_time }} - {{ $class->end_time }}</td>
                                    <td>{{ $class->subject->name }}</td>
                                    <td>{{ $class->teacher->name }}</td>
                                    <td>{{ $class->room }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted">No classes scheduled for today</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Notices -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Notices</h6>
                    <a href="{{ route('student.noticeshow') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @forelse($recentNotices as $notice)
                    <div class="mb-3 p-3 border-bottom">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-bold text-{{ $notice->is_important ? 'danger' : 'primary' }}">
                                {{ $notice->title }}
                            </h6>
                            <small class="text-muted">{{ $notice->created_at->format('M d') }}</small>
                        </div>
                        <p class="mb-2">{{ Str::limit($notice->content, 100) }}</p>
                        @if($notice->attachment)
                        <a href="{{ Storage::url($notice->attachment) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-paperclip"></i> Attachment
                        </a>
                        @endif
                    </div>
                    @empty
                    <p class="text-muted">No notices available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Study Materials -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Study Materials</h6>
                    <a href="{{ route('student.materials.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @forelse($materials as $material)
                    <div class="mb-3 p-3 border-bottom">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('student.materials.show', $material->id) }}" class="text-decoration-none">
                            <h6 class="font-weight-bold text-primary">
                                {{ $material->title }}
                            </h6>
                        </a>
                        <small class="text-muted">{{ $material->created_at->format('M d') }}</small>
                        </div>
                        <p class="mb-2">by-{{ $material->teacher_name }}</p>
                    </div>
                    @empty
                    <p class="text-muted">No notices available</p>
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
                    <a href="{{ route('student.classschedule') }}" class="btn btn-primary m-2">
                        <i class="fas fa-calendar-alt fa-fw"></i> Weekly Timetable
                    </a>
                     <a href="{{ route('student.materials.index') }}" class="btn btn-warning m-2">
                        <i class="fa fa-book"></i> Study Materials
                    </a>
                    <a href="{{ route('student.noticeshow') }}" class="btn btn-success m-2">
                        <i class="fas fa-bell fa-fw"></i> View Notices
                    </a>
                    <a href="{{ route('student.attendance.calendar') }}" class="btn btn-info m-2">
                        <i class="fas fa-clipboard-list fa-fw"></i> Attendance Record
                    </a>
                    <a href="{{ route('student.feedback') }}" class="btn btn-warning m-2">
                        <i class="fas fa-comment fa-fw"></i> Submit Feedback
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
