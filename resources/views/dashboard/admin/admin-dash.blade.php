@extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Students Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Students</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $studentsCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teachers Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Teachers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $teachersCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Classes Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Classes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $classesCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-school fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Routines Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Active Routines</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeRoutinesCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Latest Registrations -->
            <div class="col-lg-6 mb-4">
                {{-- <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Latest Student Registrations</h6>
                        <a href="{{ route('admin.members', 'student') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestStudents as $student)
                                        <tr>
                                            <td>{{ $student->unique_id }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>
                                                @if ($student->class_level)
                                                    {{ $student->class_level->name }}
                                                @else
                                                    Not assigned
                                                @endif
                                            </td>
                                            <td>{{ $student->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No students found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}
                <!-- Latest Student Registrations -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Latest Student Registrations</h6>
        <a href="{{ route('admin.members', 'student') }}" class="btn btn-sm btn-primary">View All</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>ID</th>
                        <th>Class</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestStudents as $student)
                    <tr>
                        <td class="text-center">
                            <img src="{{ $student->image ? asset('storage/'.$student->image) : asset('img/default-profile.png') }}"
                                 class="rounded-circle"
                                 width="40"
                                 height="40"
                                 alt="{{ $student->name }}">
                        </td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->unique_id }}</td>
                        <td>
                            {{ $student->class_level->name ?? 'Not assigned' }}
                        </td>
                        <td>{{ $student->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No students found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

                {{-- <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Latest Teacher Registrations</h6>
                        <a href="{{ route('admin.members', 'teacher') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestTeachers as $teacher)
                                        <tr>
                                            <td>{{ $teacher->teacher_id }}</td>
                                            <td>{{ $teacher->name }}</td>
                                            <td>{{ $teacher->subject }}</td>
                                            <td>{{ $teacher->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No teachers found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}
                <!-- Latest Teacher Registrations -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Latest Teacher Registrations</h6>
        <a href="{{ route('admin.members', 'teacher') }}" class="btn btn-sm btn-primary">View All</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestTeachers as $teacher)
                    <tr>
                        <td class="text-center">
                            <img src="{{ $teacher->image ? asset('storage/'.$teacher->image) : asset('img/default-profile.png') }}"
                                 class="rounded-circle"
                                 width="40"
                                 height="40"
                                 alt="{{ $teacher->name }}">
                        </td>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->teacher_id }}</td>
                        <td>{{ $teacher->subject }}</td>
                        <td>{{ $teacher->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No teachers found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
            </div>

            <!-- Recent Activity -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Notices</h6>
                        <a href="{{ route('admin.noticeshow') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        @forelse($recentNotices as $notice)
                            <div class="mb-3 p-3 border-bottom">
                                <div class="d-flex justify-content-between">
                                    <h6 class="font-weight-bold text-{{ $notice->is_important ? 'danger' : 'primary' }}">
                                        {{ $notice->title }}
                                    </h6>
                                    <small class="text-muted">{{ $notice->created_at->format('M d, Y') }}</small>
                                </div>
                                <p class="mb-2">{{ Str::limit($notice->content, 100) }}</p>
                                {{-- <div class="d-flex">
                            <span class="badge badge-info mr-2">
                                {{ ucfirst(implode(', ', json_decode($notice->audience))) }}
                            </span>
                            @if ($notice->attachment)
                            <a href="{{ Storage::url($notice->attachment) }}" class="badge badge-secondary">
                                <i class="fas fa-paperclip"></i> Attachment
                            </a>
                            @endif
                        </div> --}}
                                <div class="d-flex">
                                    <span class="badge badge-info mr-2">
                                        {{ ucfirst(implode(', ', $notice->audience)) }}
                                    </span>
                                    @if ($notice->attachment)
                                        <a href="{{ Storage::url($notice->attachment) }}" class="badge badge-secondary">
                                            <i class="fas fa-paperclip"></i> Attachment
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No notices available</p>
                        @endforelse
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Upcoming Holidays</h6>
                    </div>
                    <div class="card-body">
                        @forelse($upcomingHolidays as $holiday)
                            <div class="mb-3 p-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>{{ $holiday->title }}</strong>
                                    <span class="badge badge-primary">{{ $holiday->date->format('M d, Y') }}</span>
                                </div>
                                <p class="mb-0 text-muted">{{ $holiday->description }}</p>
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
                        <a href="{{ route('registerform') }}" class="btn btn-primary m-2">
                            <i class="fas fa-user-plus fa-fw"></i> Add Member
                        </a>
                        <a href="{{ route('admin.routine.create') }}" class="btn btn-success m-2">
                            <i class="fas fa-calendar-plus fa-fw"></i> Create Routine
                        </a>
                        <a href="{{ route('admin.noticeaddform') }}" class="btn btn-info m-2">
                            <i class="fas fa-bullhorn fa-fw"></i> Post Notice
                        </a>
                        <a href="{{ route('holidays.create') }}" class="btn btn-warning m-2">
                            <i class="fas fa-calendar-day fa-fw"></i> Add Holiday
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
