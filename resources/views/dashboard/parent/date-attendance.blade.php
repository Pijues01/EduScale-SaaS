@extends('dashboard.layout.master')

@section('content')
    <div class="container">
        <h4>My Attendance on {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}</h4>
        {{-- <a href="{{ route('parent.attendance.calendar') }}" class="btn btn-sm btn-secondary mb-3">
            ← Back to Calendar
        </a> --}}
        {{-- <a href="{{ route('parent.attendance.calendar', ['id' => $attendance->first()->student_id ?? '']) }}"
            class="btn btn-sm btn-secondary mb-3">
            ← Back to Calendar
        </a> --}}
        <a href="{{ route('parent.attendance.calendar', ['id' => $studentId]) }}" class="btn btn-sm btn-secondary mb-3">
    ← Back to Calendar
</a>

        <div class="card">
            <div class="card-body">
                @if ($attendance->count() > 0)
                    <div class="list-group">
                        @foreach ($attendance as $record)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>{{ $record->classRoutine->subject->sub_name ?? 'N/A' }}</h6>
                                        <small class="text-muted">
                                            {{ $record->classRoutine->start_time }} - {{ $record->classRoutine->end_time }}
                                        </small>
                                    </div>
                                    <span class="badge badge-{{ $record->status ? 'success' : 'danger' }}">
                                        {{ $record->status ? 'Present' : 'Absent' }}
                                    </span>
                                </div>
                                @if ($record->remarks)
                                    <div class="mt-2 small">
                                        <strong>Remarks:</strong> {{ $record->remarks }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        No classes found for this date
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
