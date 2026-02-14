@extends('dashboard.layout.master')

@section('content')
<div class="container">
    <h2>Edit Routine</h2>

    <form action="{{ route('admin.routine.update', $routine->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Branch</label>
                    <select class="form-control" name="branch_id" required>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $routine->branch_id == $branch->id ? 'selected' : '' }}>
                            {{ $branch->branch_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Class Level</label>
                    <select class="form-control" name="class_level_id" required>
                        @foreach($classLevels as $classLevel)
                        <option value="{{ $classLevel->id }}" {{ $routine->class_level_id == $classLevel->id ? 'selected' : '' }}>
                            {{ $classLevel->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Day of Week</label>
                    <select class="form-control" name="day_of_week" required>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                        <option value="{{ $day }}" {{ $routine->day_of_week == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Start Time</label>
                    <input type="time" class="form-control" name="start_time" value="{{ $routine->start_time }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>End Time</label>
                    <input type="time" class="form-control" name="end_time" value="{{ $routine->end_time }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Subject</label>
                    <select class="form-control" name="subject_id" required>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $routine->subject_id == $subject->id ? 'selected' : '' }}>
                            {{ $subject->sub_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Teacher</label>
                    <select class="form-control" name="teacher_id" required>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->teacher_id }}" {{ $routine->teacher_id == $teacher->teacher_id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Routine</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
