@extends('dashboard.layout.master')

@section('content')
<div class="container">
    <h2>Classes on {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}</h2>
    <a href="{{ route('attendance.calendar') }}" class="btn btn-secondary mb-3">Back to Calendar</a>

    @foreach($classes as $branchId => $branchClasses)
        @php $branch = $branchClasses->first()->branch; @endphp
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>{{ $branch->name }} (Branch)</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($branchClasses as $class)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $class->classLevel->name }}</h5>
                                    <p class="card-text">
                                        {{ $class->subject->name }}<br>
                                        {{ $class->start_time }} - {{ $class->end_time }}<br>
                                        Teacher: {{ $class->teacher->name }}
                                    </p>
                                    <a href="{{ route('attendance.class-attendance', ['class_routine_id' => $class->id, 'date' => $date]) }}"
                                       class="btn btn-primary">
                                        View Attendance
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
