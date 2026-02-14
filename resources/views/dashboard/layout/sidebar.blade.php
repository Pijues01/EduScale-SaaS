<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ route($user->role . '.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ICA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route($user->role . '.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    @if ($user->role == 'admin')
        <div class="sidebar-heading">
            Interface
        </div>


        <!-- Nav Item - Pages Collapse Menu -->
        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Members</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Member Management:</h6>
                    <a class="collapse-item" href="{{ route('registerform') }}">Add Member</a>
                    <a class="collapse-item" href="{{ route('admin.members', 'student') }}">Show All students</a>
                    <a class="collapse-item" href="{{ route('admin.members', 'teacher') }}">Show All Teachers</a>
                    <a class="collapse-item" href="{{ route('admin.members', 'parent') }}">Show All Parents</a>
                </div>
            </div>
        </li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Routine</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Routine Management:</h6>
                    <a class="collapse-item" href="{{ route('admin.routine.create') }}">New Routine</a>
                    <a class="collapse-item" href="{{ route('admin.routine') }}">Show All Routine</a>
                    <!-- <a class="collapse-item" href="{{ route('admin.members', 'teacher') }}">Show All Teachers</a>
                        <a class="collapse-item" href="{{ route('admin.members', 'parent') }}">Show All Parents</a> -->
                </div>
            </div>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMembers"
                aria-expanded="true" aria-controls="collapseMembers">
                <i class="fas fa-fw fa-cog"></i>
                <span>Members</span>
            </a>
            <div id="collapseMembers" class="collapse" aria-labelledby="headingMembers" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Member Management:</h6>
                    <a class="collapse-item" href="{{ route('registerform') }}">Add Member</a>
                    <a class="collapse-item" href="{{ route('admin.members', 'student') }}">Show All students</a>
                    <a class="collapse-item" href="{{ route('admin.members', 'teacher') }}">Show All Teachers</a>
                    <a class="collapse-item" href="{{ route('admin.members', 'parent') }}">Show All Parents</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRoutine"
                aria-expanded="true" aria-controls="collapseRoutine">
                <i class="fas fa-fw fa-cog"></i>
                <span>Routine</span>
            </a>
            <div id="collapseRoutine" class="collapse" aria-labelledby="headingRoutine" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Routine Management:</h6>
                    <a class="collapse-item" href="{{ route('admin.routine.create') }}">Create New Routine</a>
                    <a class="collapse-item" href="{{ route('admin.routine') }}">Show All Routine</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSubject"
                aria-expanded="true" aria-controls="collapseSubject">
                <i class="fas fa-fw fa-cog"></i>
                <span>Subject</span>
            </a>
            <div id="collapseSubject" class="collapse" aria-labelledby="headingSubject" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Subject Management:</h6>
                    <a class="collapse-item" href="{{ route('admin.addsubject') }}">Add New Subject</a>
                    <a class="collapse-item" href="{{ route('admin.subjects') }}">Show All Subject</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFeedback"
                aria-expanded="true" aria-controls="collapseFeedback">
                <i class="fas fa-fw fa-cog"></i>
                <span>Feedback</span>
            </a>
            <div id="collapseFeedback" class="collapse" aria-labelledby="headingFeedback"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Feedback Management:</h6>
                    <a class="collapse-item" href="{{ route('admin.feedbacks') }}">Feedbacks</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAttendence"
                aria-expanded="true" aria-controls="collapseAttendence">
                <i class="fas fa-fw fa-cog"></i>
                <span>Attendence</span>
            </a>
            <div id="collapseAttendence" class="collapse" aria-labelledby="headingAttendence"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Attendence Management:</h6>
                    <a class="collapse-item" href="{{ route('admin.todayclass') }}">Today Class</a>
                    <a class="collapse-item" href="{{ route('attendance.calendar') }}">Show All Attendence</a>
                </div>
            </div>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHolidays"
                aria-expanded="true" aria-controls="collapseHolidays">
                <i class="fas fa-fw fa-cog"></i>
                <span>Holidays</span>
            </a>
            <div id="collapseHolidays" class="collapse" aria-labelledby="headingHolidays"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Holidays Management:</h6>
                    <a class="collapse-item" href="{{ route('holidays.index') }}">Holidays Add</a>
                    <a class="collapse-item" href="{{ route('holidays.calendar') }}">Show All Holidays</a>
                    <a class="collapse-item" href="{{ route('holidays.calendar') }}">calender Holidays</a>
                </div>
            </div>
        </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHolidays"
                aria-expanded="true" aria-controls="collapseHolidays">
                <i class="fas fa-calendar-alt"></i>
                <span>Holidays</span>
            </a>
            <div id="collapseHolidays" class="collapse" aria-labelledby="headingHolidays"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Holidays Management:</h6>
                    <a class="collapse-item" href="{{ route('holidays.index') }}">Manage Holidays</a>
                    <a class="collapse-item" href="{{ route('holidays.create') }}">Add Holiday</a>
                    <a class="collapse-item" href="{{ route('holidays.calendar') }}">Calendar View</a>
                </div>
            </div>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('holidays.index') }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Holidays</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.leave.index') }}">
                <i class="fas fa-tasks me-2"></i> <span>Manage Leave Applications</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.objections') }}">
                <i class="fas fa-tasks me-2"></i> <span>Objections Management</span>
            </a>
        </li>



        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Website</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Notices:</h6>
                    <a class="collapse-item" href="{{ route('admin.noticeaddform') }}">New Notice</a>
                    <a class="collapse-item" href="{{ route('admin.noticeshow') }}">View Notices</a>
                    <h6 class="collapse-header">Branches:</h6>
                    <a class="collapse-item" href="{{ route('admin.branches.create') }}">New Branches</a>
                    <a class="collapse-item" href="{{ route('admin.branches') }}">Branches</a>
                    <h6 class="collapse-header">Gallery:</h6>
                    <a class="collapse-item" href="{{ route('admin.gallery') }}">Gallery</a>
                    <h6 class="collapse-header">Jobs:</h6>
                    <a class="collapse-item" href="{{ route('admin.jobs.create') }}">New Job</a>
                    <a class="collapse-item" href="{{ route('admin.jobs') }}">All Job</a>
                    <h6 class="collapse-header">Job Applications:</h6>
                    <a class="collapse-item" href="{{ route('admin.viewapplication') }}">Applications</a>

                </div>

            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.contacts.view') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Contacts</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.consults.view') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Consults</span></a>
        </li>
    @endif

    @if ($user->role == 'teacher')
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            {{-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">ICA</div>
            </a> --}}

            <!-- Divider -->
            {{-- <hr class="sidebar-divider my-0"> --}}

            <!-- Nav Item - Dashboard -->
            {{-- <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
            </li> --}}

            <!-- Divider -->
            {{-- <hr class="sidebar-divider"> --}}

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher.schedule') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Class Shedule</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-tasks me-2"></i>
                    <span>Notices </span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Notices :</h6>
                        <a class="collapse-item" href="{{ route('teacher.noticeshow') }}">Teacher Notices</a>
                        <a class="collapse-item" href="{{ route('teacher.noticeshow.general') }}">General Notices</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTw"
                    aria-expanded="true" aria-controls="collapseTw">
                    <i class="fas fa-tasks me-2"></i>
                    <span>Materials</span>
                </a>
                <div id="collapseTw" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Materials :</h6>
                        <a class="collapse-item" href="{{ route('materials.create') }}">Materials Create</a>
                        <a class="collapse-item" href="{{ route('materials.index') }}">Materials</a>
                    </div>
                </div>
            </li>
             {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('materials.create') }}">
                    <i class="fas fa-tasks me-2"></i> <span>materials create</span>
                </a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="{{ route('materials.index') }}">
                    <i class="fas fa-tasks me-2"></i> <span>materials</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher.holidays.index') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Holidays</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route(auth()->user()->role . '.leave.create') }}">
                    <i class="fas fa-calendar-minus me-2"></i>  <span>Apply for Leave </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher.feedback') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Feedback or Objection</span>
                </a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Utilities</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Utilities:</h6>
                    <a class="collapse-item" href="utilities-color.html">Colors</a>
                    <a class="collapse-item" href="utilities-border.html">Borders</a>
                    <a class="collapse-item" href="utilities-animation.html">Animations</a>
                    <a class="collapse-item" href="utilities-other.html">Other</a>
                </div>
            </div>
            </li> --}}

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            {{-- <div class="sidebar-heading">
            Addons
            </div> --}}

            <!-- Nav Item - Pages Collapse Menu -->
            {{-- <li class="nav-item active">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="login.html">Login</a>
                    <a class="collapse-item" href="register.html">Register</a>
                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Other Pages:</h6>
                    <a class="collapse-item" href="404.html">404 Page</a>
                    <a class="collapse-item active" href="blank.html">Blank Page</a>
                </div>
            </div>
            </li> --}}

            <!-- Nav Item - Charts -->
            {{-- <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
            </li> --}}

            <!-- Nav Item - Tables -->
            {{-- <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
            </li> --}}

            <!-- Divider -->
            {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

            <!-- Sidebar Toggler (Sidebar) -->
            {{-- <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> --}}

        </ul>
    @endif
    @if ($user->role == 'student')
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            {{-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">ICA</div>
            </a> --}}

            <!-- Divider -->
            {{-- <hr class="sidebar-divider my-0"> --}}

            <!-- Nav Item - Dashboard -->
            {{-- <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
            </li> --}}

            <!-- Divider -->
            {{-- <hr class="sidebar-divider"> --}}

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.classschedule') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Class Shedule</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.attendance.calendar') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Attendence</span>
                </a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-tasks me-2"></i>
                    <span>Notices</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Notices:</h6>
                        <a class="collapse-item" href="{{ route('student.noticeshow') }}">Student Notices</a>
                        <a class="collapse-item" href="{{ route('student.noticeshow.general') }}">General Notices</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.materials.index') }}">
                    <i class="fas fa-tasks me-2"></i> <span>materials</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.feedback') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Feedback</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.holidays.index') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Holidays</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route(auth()->user()->role . '.leave.create') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Leave Apply</span>
                </a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Feedback</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Feedback Manegment:</h6>
                        <a class="collapse-item" href="{{ route('student.feedback') }}">Feedback</a>
                        <a class="collapse-item" href="{{ route('student.holidays.index') }}">Holidays</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route(auth()->user()->role . '.leave.create') }}">
                    <i class="fas fa-calendar-minus me-2"></i> Apply for Leave
                </a>
            </li> --}}

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            {{-- <div class="sidebar-heading">
            Addons
            </div> --}}

            <!-- Nav Item - Pages Collapse Menu -->
            {{-- <li class="nav-item active">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="login.html">Login</a>
                    <a class="collapse-item" href="register.html">Register</a>
                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Other Pages:</h6>
                    <a class="collapse-item" href="404.html">404 Page</a>
                    <a class="collapse-item active" href="blank.html">Blank Page</a>
                </div>
            </div>
            </li> --}}

            <!-- Nav Item - Charts -->
            {{-- <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
            </li> --}}

            <!-- Nav Item - Tables -->
            {{-- <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
            </li> --}}

            <!-- Divider -->
            {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

            <!-- Sidebar Toggler (Sidebar) -->
            {{-- <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> --}}

        </ul>
    @endif
    @if ($user->role == 'parent')
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            {{-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">ICA</div>
            </a> --}}

            <!-- Divider -->
            {{-- <hr class="sidebar-divider my-0"> --}}

            <!-- Nav Item - Dashboard -->
            {{-- <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
            </li> --}}

            <!-- Divider -->
            {{-- <hr class="sidebar-divider"> --}}

            <!-- Heading -->
            <div class="sidebar-heading">
                Menus
            </div>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('parent.children') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Childrens</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-tasks me-2"></i>
                    <span>Notices</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Notices:</h6>
                        <a class="collapse-item" href="{{ route('parent.notices.general') }}">General Notice</a>
                        <a class="collapse-item" href="{{ route('parent.notices') }}">Parent Notice</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('parent.objections') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Objections</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('parent.feedback') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Feedback</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('parent.holidays.index') }}">
                    <i class="fas fa-tasks me-2"></i> <span>Holidays</span>
                </a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Utilities</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Utilities:</h6>
                    <a class="collapse-item" href="utilities-color.html">Colors</a>
                    <a class="collapse-item" href="utilities-border.html">Borders</a>
                    <a class="collapse-item" href="utilities-animation.html">Animations</a>
                    <a class="collapse-item" href="utilities-other.html">Other</a>
                </div>
            </div>
            </li> --}}

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            {{-- <div class="sidebar-heading">
            Addons
            </div> --}}

            <!-- Nav Item - Pages Collapse Menu -->
            {{-- <li class="nav-item active">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="login.html">Login</a>
                    <a class="collapse-item" href="register.html">Register</a>
                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Other Pages:</h6>
                    <a class="collapse-item" href="404.html">404 Page</a>
                    <a class="collapse-item active" href="blank.html">Blank Page</a>
                </div>
            </div>
            </li> --}}

            <!-- Nav Item - Charts -->
            {{-- <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
            </li> --}}

            <!-- Nav Item - Tables -->
            {{-- <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
            </li> --}}

            <!-- Divider -->
            {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

            <!-- Sidebar Toggler (Sidebar) -->
            {{-- <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> --}}

        </ul>
    @endif
    <!-- Heading -->
    {{-- <div class="sidebar-heading">
        Addons
    </div> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item active">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item active" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li> --}}

    <!-- Nav Item - Charts -->

    {{-- This was open --}}

    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.contacts.view') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Contacts</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.consults.view') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Consults</span></a>
    </li> --}}



    {{-- <li class="nav-item">
        <a class="nav-link" href="{{route('admin.gallery')}}">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>Gallery</span></a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{route('admin.branches.create')}}">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>Branches Create</span></a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{route('admin.branches')}}">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>Branches</span></a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{route('admin.jobs')}}">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>All Jobs</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.jobs.create')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Jobs Create</span></a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Applications</span></a>
    </li> --}}

    <!-- Nav Item - Tables -->
    {{-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> --}}

    <!-- Divider -->
    {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

{{-- @stack('sidebar') --}}
