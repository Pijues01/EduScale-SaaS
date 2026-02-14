{{-- @extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Attendance</h4>
                <p>Class: {{ $classLevel->name }} | Branch: {{ $branch->branch_name }} | Date:
                    {{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('attendance.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="class_routine_id" value="{{ $r_id }}">
                    <input type="hidden" name="date" value="{{ \Carbon\Carbon::today()->toDateString() }}">

                    <!-- Teacher Attendance Section -->
                    <div class="mb-4 p-3 border rounded bg-light">
                        <h5>Teacher Attendance</h5>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        @if ($teacher->image)
                                            <img src="{{ asset('storage/' . $teacher->image) }}"
                                                class="rounded-circle border" width="50" height="50"
                                                alt="{{ $teacher->name }}">
                                        @else
                                            <div class="avatar-placeholder rounded-circle bg-light text-center d-flex align-items-center justify-content-center"
                                                style="width:50px; height:50px;">
                                                <i class="fas fa-user-tie text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $teacher->name }}</h6>
                                        <small class="text-muted">Teacher</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="teacher_attendance"
                                        name="teacher_attendance[status]" value="1">
                                    <label class="form-check-label" for="teacher_attendance">
                                        Present
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <textarea class="form-control" name="teacher_attendance[remarks]" rows="1" placeholder="Teacher remarks"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Student Attendance Section -->
                    @if ($students->isEmpty())
                        <div class="alert alert-info">No students found for this class.</div>
                    @else
                        <div class="table-responsive">
                            <table id="studentsTable" class="table table-hover align-middle mb-0" style="width:100%">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Student</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $index => $student)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        @if ($student->image)
                                                            <img src="{{ asset('storage/' . $student->image) }}"
                                                                class="rounded-circle border" width="40" height="40"
                                                                alt="{{ $student->name }}">
                                                        @else
                                                            <div class="avatar-placeholder rounded-circle bg-light text-center d-flex align-items-center justify-content-center"
                                                                style="width:40px; height:40px;">
                                                                <i class="fas fa-user text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0">{{ $student->name }}</h6>
                                                        <small class="text-muted">ID: {{ $student->stu_id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input attendance-checkbox" type="checkbox"
                                                        id="attendance_{{ $student->stu_id }}"
                                                        name="attendance[{{ $student->stu_id }}][status]" value="1"
                                                        {{ old("attendance.{$student->stu_id}.status", false) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="attendance_{{ $student->stu_id }}">
                                                        Present
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea class="form-control form-control-sm remarks-textarea" name="attendance[{{ $student->stu_id }}][remarks]"
                                                    rows="1" placeholder="Optional remarks"></textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Attendance
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // $(document).ready(function() {
        //     // Initialize all checkboxes as unchecked by default
        //     $('.attendance-checkbox').prop('checked', false);

        //     // Toggle attendance status label
        //     $('.attendance-checkbox').change(function() {
        //         const label = $(this).next('label');
        //         label.text($(this).is(':checked') ? 'Present' : 'Absent');
        //     });

        //     // Toggle teacher attendance status
        //     $('#teacher_attendance').change(function() {
        //         const label = $(this).next('label');
        //         label.text($(this).is(':checked') ? 'Present' : 'Absent');
        //     });
        // });
        $(document).ready(function() {
            // Initialize teacher checkbox as unchecked
            $('#teacher_attendance').prop('checked', false);

            // Initialize student checkboxes as unchecked
            $('.attendance-checkbox').prop('checked', false);

            // Toggle teacher attendance label
            $('#teacher_attendance').change(function() {
                const label = $(this).next('label');
                label.text($(this).is(':checked') ? 'Present' : 'Absent');
            });

            // Toggle student attendance labels
            $('.attendance-checkbox').change(function() {
                const label = $(this).next('label');
                label.text($(this).is(':checked') ? 'Present' : 'Absent');
            });
        });
    </script>
@endpush --}}


@extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Attendance</h4>
                <p>Class: {{ $classLevel->name }} | Branch: {{ $branch->branch_name }} | Date:
                    {{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('attendance.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="class_routine_id" value="{{ $r_id }}">
                    <input type="hidden" name="date" value="{{ \Carbon\Carbon::today()->toDateString() }}">

                    <!-- Teacher Attendance Section -->
                    <div class="mb-4 p-3 border rounded bg-light">
                        <h5>Teacher Attendance</h5>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        @if ($teacher->image)
                                            <img src="{{ asset('storage/' . $teacher->image) }}"
                                                class="rounded-circle border" width="50" height="50"
                                                alt="{{ $teacher->name }}">
                                        @else
                                            <div class="avatar-placeholder rounded-circle bg-light text-center d-flex align-items-center justify-content-center"
                                                style="width:50px; height:50px;">
                                                <i class="fas fa-user-tie text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $teacher->name }}</h6>
                                        <small class="text-muted">Teacher</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="teacher_attendance"
                                        name="teacher_attendance[status]" value="1"
                                        {{ $teacherAttendance && $teacherAttendance->status ? 'checked' : '' }}>
                                    <label class="form-check-label" for="teacher_attendance">
                                        Present
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <textarea class="form-control" name="teacher_attendance[remarks]" rows="1" placeholder="Teacher remarks">{{ $teacherAttendance->remarks ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Student Attendance Section -->
                    @if ($students->isEmpty())
                        <div class="alert alert-info">No students found for this class.</div>
                    @else
                        <div class="table-responsive">
                            <table id="studentsTable" class="table table-hover align-middle mb-0" style="width:100%">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Student</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $index => $student)
                                        @php
                                            $attendanceRecord = $studentAttendanceRecords[$student->stu_id] ?? null;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        @if ($student->image)
                                                            <img src="{{ asset('storage/' . $student->image) }}"
                                                                class="rounded-circle border" width="40" height="40"
                                                                alt="{{ $student->name }}">
                                                        @else
                                                            <div class="avatar-placeholder rounded-circle bg-light text-center d-flex align-items-center justify-content-center"
                                                                style="width:40px; height:40px;">
                                                                <i class="fas fa-user text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0">{{ $student->name }}</h6>
                                                        <small class="text-muted">ID: {{ $student->stu_id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input attendance-checkbox" type="checkbox"
                                                        id="attendance_{{ $student->stu_id }}"
                                                        name="attendance[{{ $student->stu_id }}][status]" value="1"
                                                        {{ $attendanceRecord && $attendanceRecord->status ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="attendance_{{ $student->stu_id }}">
                                                        Present
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea class="form-control form-control-sm remarks-textarea" name="attendance[{{ $student->stu_id }}][remarks]"
                                                    rows="1" placeholder="Optional remarks">{{ $attendanceRecord->remarks ?? '' }}</textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Attendance
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Toggle teacher attendance label based on initial state
            const teacherCheckbox = $('#teacher_attendance');
            teacherCheckbox.next('label').text(teacherCheckbox.is(':checked') ? 'Present' : 'Absent');

            // Toggle teacher attendance status
            teacherCheckbox.change(function() {
                $(this).next('label').text($(this).is(':checked') ? 'Present' : 'Absent');
            });

            // Initialize and toggle student attendance labels
            $('.attendance-checkbox').each(function() {
                const label = $(this).next('label');
                label.text($(this).is(':checked') ? 'Present' : 'Absent');

                $(this).change(function() {
                    label.text($(this).is(':checked') ? 'Present' : 'Absent');
                });
            });
        });
    </script>
@endpush
