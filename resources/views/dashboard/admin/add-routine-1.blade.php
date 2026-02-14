@extends('dashboard.layout.master')



@section('content')
<div class="container">
    <h1>Create New Routine</h1>

    <form action="{{ route('admin.routine.store') }}" method="POST" id="routineForm">
        @csrf

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="branch_id">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-control" required>
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="class_level_id">Class</label>
                    <select name="class_level_id" id="class_level_id" class="form-control" required>
                        <option value="">Select Class</option>
                        @foreach($classLevels as $level)
                        <option value="{{ $level['id'] }}">{{ $level['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="day_of_week">Day of Week</label>
                    <select name="day_of_week" id="day_of_week" class="form-control" required>
                        <option value="">Select Day</option>
                        @foreach($days as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <h3 class="mt-4">Class Periods</h3>

        <!-- Before Break Periods -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>Before Break Periods</span>
                <button type="button" class="btn btn-sm btn-light" id="addBeforeBreakPeriod">Add Period</button>
            </div>
            <div class="card-body" id="beforeBreakPeriods">
                <!-- Periods will be added here dynamically -->
                <div class="row period-row mb-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Subject</label>
                            <select name="periods[0][subject_id]" class="form-control subject-select" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->sub_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Teacher</label>
                            <select name="periods[0][teacher_id]" class="form-control teacher-select" required>
                                <option value="">Select Teacher</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" name="periods[0][start_time]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>End Time</label>
                            <input type="time" name="periods[0][end_time]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-period">Remove</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Break Time -->
        <div class="card mb-4">
            <div class="card-header bg-warning">
                Break Time
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Break Start Time</label>
                            <input type="time" name="break_start" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Break End Time</label>
                            <input type="time" name="break_end" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- After Break Periods -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>After Break Periods</span>
                <button type="button" class="btn btn-sm btn-light" id="addAfterBreakPeriod">Add Period</button>
            </div>
            <div class="card-body" id="afterBreakPeriods">
                <!-- Periods will be added here dynamically -->
                <div class="row period-row mb-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Subject</label>
                            <select name="periods[1][subject_id]" class="form-control subject-select" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->sub_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Teacher</label>
                            <select name="periods[1][teacher_id]" class="form-control teacher-select" required>
                                <option value="">Select Teacher</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" name="periods[1][start_time]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>End Time</label>
                            <input type="time" name="periods[1][end_time]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-period">Remove</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save Routine</button>
        <a href="{{ route('admin.routine') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    let beforeBreakPeriodCount = 1;
    let afterBreakPeriodCount = 1;
    let periodIndex = 2; // Starting from 2 because we already have 0 and 1

    // Add before break period
    $('#addBeforeBreakPeriod').click(function() {
        const newPeriod = `
        <div class="row period-row mb-3">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Subject</label>
                    <select name="periods[${periodIndex}][subject_id]" class="form-control subject-select" required>
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->sub_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Teacher</label>
                    <select name="periods[${periodIndex}][teacher_id]" class="form-control teacher-select" required>
                        <option value="">Select Teacher</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Start Time</label>
                    <input type="time" name="periods[${periodIndex}][start_time]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>End Time</label>
                    <input type="time" name="periods[${periodIndex}][end_time]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-period">Remove</button>
            </div>
        </div>
        `;

        $('#beforeBreakPeriods').append(newPeriod);
        beforeBreakPeriodCount++;
        periodIndex++;
    });

    // Add after break period
    $('#addAfterBreakPeriod').click(function() {
        const newPeriod = `
        <div class="row period-row mb-3">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Subject</label>
                    <select name="periods[${periodIndex}][subject_id]" class="form-control subject-select" required>
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->sub_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Teacher</label>
                    <select name="periods[${periodIndex}][teacher_id]" class="form-control teacher-select" required>
                        <option value="">Select Teacher</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Start Time</label>
                    <input type="time" name="periods[${periodIndex}][start_time]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>End Time</label>
                    <input type="time" name="periods[${periodIndex}][end_time]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-period">Remove</button>
            </div>
        </div>
        `;

        $('#afterBreakPeriods').append(newPeriod);
        afterBreakPeriodCount++;
        periodIndex++;
    });

    // Remove period
    $(document).on('click', '.remove-period', function() {
        if ($('#beforeBreakPeriods .period-row').length > 1 || $('#afterBreakPeriods .period-row').length > 1) {
            $(this).closest('.period-row').remove();
        } else {
            alert('You must have at least one period before and after break.');
        }
    });

    // Subject change handler
    $(document).on('change', '.subject-select', function() {
        let subjectId = $(this).val();
        let teacherSelect = $(this).closest('.period-row').find('.teacher-select');

        if (subjectId) {
            $.ajax({
                url: "{{ route('admin.get.teachers.by.subject') }}",
                type: "GET",
                data: { subject_id: subjectId },
                success: function(data) {
                    teacherSelect.empty();
                    teacherSelect.append('<option value="">Select Teacher</option>');
                    $.each(data, function(key, teacher) {
                        teacherSelect.append(`<option value="${teacher.id}">${teacher.name}</option>`);
                    });
                }
            });
        } else {
            teacherSelect.empty();
            teacherSelect.append('<option value="">Select Teacher</option>');
        }
    });

    // Form submission handler to ensure at least one period before and after break
    $('#routineForm').submit(function(e) {
        if ($('#beforeBreakPeriods .period-row').length === 0) {
            e.preventDefault();
            alert('Please add at least one period before break.');
            return false;
        }

        if ($('#afterBreakPeriods .period-row').length === 0) {
            e.preventDefault();
            alert('Please add at least one period after break.');
            return false;
        }
    });
});
</script>
@endpush
