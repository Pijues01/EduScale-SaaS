@extends('dashboard.layout.master')

@section('content')
    <div class="container">
        <h2>Attendance for {{ $class->classLevel->name }} - {{ $class->subject->name }}</h2>
        <h4>{{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }} ({{ $class->start_time }} - {{ $class->end_time }})</h4>

        <a href="{{ route('attendance.date-classes') }}?date={{ $date }}" class="btn btn-secondary mb-3">Back to
            Classes</a>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    {{-- <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        {{ $student->image }}
                            @php
                                $attendance = $attendanceRecords[$student->stu_id] ?? null;
                                $status = $attendance ? ($attendance->status ? 'Present' : 'Absent') : 'Not Recorded';
                                $statusClass = $attendance ? ($attendance->status ? 'text-success' : 'text-danger') : 'text-secondary';
                            @endphp
                            <tr>
                                <td>{{ $student->stu_id }}</td>
                                <td><img src="{{ asset('storage/'. $student->image) }}" class="img-thumbnail" width="50"></td>
                                <td>{{ $student->name }}</td>
                                <td class="{{ $statusClass }}">{{ $status }}</td>
                                <td>{{ $attendance ? $attendance->remarks : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Class Attendance</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center" style="width: 80px;">Image</th>
                                            <th>Student ID</th>
                                            <th>Name</th>
                                            <th class="text-center">Status</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            @php
                                                $attendance = $attendanceRecords[$student->stu_id] ?? null;
                                                $status = $attendance
                                                    ? ($attendance->status
                                                        ? 'Present'
                                                        : 'Absent')
                                                    : 'Not Recorded';
                                                $statusClass = $attendance
                                                    ? ($attendance->status
                                                        ? 'success'
                                                        : 'danger')
                                                    : 'secondary';
                                                $imagePath = $student->image
                                                    ? asset('storage/' . $student->image)
                                                    : asset('images/default-student.png');
                                            @endphp
                                            <tr>
                                                <td class="text-center align-middle">
                                                    <img src="{{ $imagePath }}" class="rounded-circle border"
                                                        width="50" height="50" alt="{{ $student->name }}"
                                                        onerror="this.onerror=null;this.src='{{ asset('https://cdn-icons-png.flaticon.com/512/4537/4537019.png') }}'">
                                                </td>
                                                <td class="align-middle">{{ $student->stu_id }}</td>
                                                <td class="align-middle font-weight-bold">{{ $student->name }}</td>
                                                <td class="text-center align-middle">
                                                    <span class="badge badge-pill badge-{{ $statusClass }}">
                                                        {{ $status }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    {{ $attendance ? $attendance->remarks : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- For 2nd table css: --}}
@push('css')

<style>
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .badge-success {
        background-color: #28a745;
        min-width: 80px;
        padding: 5px 10px;
    }

    .badge-danger {
        background-color: #dc3545;
        min-width: 80px;
        padding: 5px 10px;
    }

    .badge-secondary {
        background-color: #6c757d;
        min-width: 80px;
        padding: 5px 10px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .rounded-circle {
        object-fit: cover;
    }
</style>
@endpush
