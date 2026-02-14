@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Teacher Dashboard</h1>
        <div class="d-none d-sm-inline-block">
            <span class="badge badge-primary">{{ Auth::user()->subject->name ?? 'Teacher' }}</span>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Classes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Classes Teaching</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $classes->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $studentsCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                    <h6 class="m-0 font-weight-bold text-primary">Today's Teaching Schedule</h6>
                </div>
                <div class="card-body">
                    @if($todayClasses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Room</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayClasses as $class)
                                <tr>
                                    <td>{{ $class->start_time }} - {{ $class->end_time }}</td>
                                    <td>{{ $class->class_levels->name }}</td>
                                    <td>{{ $class->subject->name }}</td>
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
                    <a href="{{ route('teacher.noticeshow') }}" class="btn btn-sm btn-primary">View All</a>
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
                        @if($notice->is_general)
                        <span class="badge badge-info">General Notice</span>
                        @endif
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
                    <a href="{{ route('teacher.schedule') }}" class="btn btn-primary m-2">
                        <i class="fas fa-calendar-alt fa-fw"></i> My Timetable
                    </a>
                    <a href="{{ route('teacher.schedule') }}" class="btn btn-success m-2">
                        <i class="fas fa-chalkboard fa-fw"></i> My Classes
                    </a>
                    <a href="{{ route('teacher.leave.create') }}" class="btn btn-info m-2">
                        <i class="fas fa-clipboard-check fa-fw"></i> Apply Leave
                    </a>
                    <a href="{{ route('teacher.objections.store') }}" class="btn btn-warning m-2">
                        <i class="fas fa-bell fa-fw"></i> Student Objection
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
