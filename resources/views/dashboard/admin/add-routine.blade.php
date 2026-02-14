@extends('dashboard.layout.master')

@section('content')
    <div class="container">
        <h2>Create Weekly Routine</h2>
        <form method="POST" action="{{ route('admin.routine.store') }}">
            @csrf
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="branch_id">Branch</label>
                        <select class="form-control" id="branch_id" name="branch_id" required>
                            <option value="">Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="class_level_id">Class Level</label>
                        <select class="form-control" id="class_level_id" name="class_level_id" required>
                            <option value="">Select Class Level</option>
                            @foreach ($classLevels as $classLevel)
                                <option value="{{ $classLevel->id }}">{{ $classLevel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="weekly-routine-container">
                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                    <div class="card mb-3 day-card" data-day="{{ $day }}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $day }}</h5>
                            <button type="button" class="btn btn-sm btn-success add-period" data-day="{{ $day }}">
                                <i class="fas fa-plus"></i> Add Period
                            </button>
                        </div>
                        <div class="card-body periods-container" id="{{ $day }}-periods">
                            <!-- Periods will be added here -->
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Weekly Routine
                </button>
            </div>

            <!-- Template for period row (using proper template tag) -->
            <template id="period-template">
                <div class="period-row row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label>Start Time</label>
                        <input type="time" class="form-control" name="routine[DAY][INDEX][start_time]" required>
                    </div>
                    <div class="col-md-3">
                        <label>End Time</label>
                        <input type="time" class="form-control" name="routine[DAY][INDEX][end_time]" required>
                    </div>
                    <div class="col-md-3">
                        <label>Subject</label>
                        <select class="form-control" name="routine[DAY][INDEX][subject_id]" required>
                            <option value="">Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->sub_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Teacher</label>
                        <select class="form-control" name="routine[DAY][INDEX][teacher_id]" required>
                            <option value="">Select Teacher</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->teacher_id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-period mt-4">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </template>
        </form>
    </div>
@endsection

@push('js')
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     let periodIndex = 0;

        //     // Function to add a new period
        //     function addPeriod(day) {
        //         const container = document.getElementById(`${day}-periods`);
        //         const template = document.getElementById('period-template');

        //         if (!template) {
        //             console.error('Template element not found!');
        //             return;
        //         }

        //         // Clone the template content
        //         const newPeriod = template.content.cloneNode(true);

        //         // Update all input names with the current index
        //         const inputs = newPeriod.querySelectorAll('[name]');
        //         inputs.forEach(input => {
        //             input.name = input.name.replace('DAY', day).replace('INDEX', periodIndex++);
        //         });

        //         container.appendChild(newPeriod);
        //     }

        //     // Delegate add period functionality
        //     document.getElementById('weekly-routine-container').addEventListener('click', function(e) {
        //         if (e.target.classList.contains('add-period') || e.target.closest('.add-period')) {
        //             const button = e.target.classList.contains('add-period') ? e.target : e.target.closest('.add-period');
        //             addPeriod(button.dataset.day);
        //         }
        //     });

        //     // Delegate remove period functionality
        //     document.getElementById('weekly-routine-container').addEventListener('click', function(e) {
        //         if (e.target.classList.contains('remove-period') || e.target.closest('.remove-period')) {
        //             const periodRow = e.target.closest('.period-row');
        //             if (periodRow) {
        //                 periodRow.remove();
        //             }
        //         }
        //     });
        // });

        document.addEventListener('DOMContentLoaded', function() {
            let periodIndex = 0;

            // Function to add a new period
            function addPeriod(day) {
                const container = document.getElementById(`${day}-periods`);
                const template = document.getElementById('period-template');

                if (!template) {
                    console.error('Template element not found!');
                    return;
                }

                // Clone the template content
                const newPeriod = template.content.cloneNode(true);

                // Update all input names with the current index
                const inputs = newPeriod.querySelectorAll('[name]');
                const currentIndex = periodIndex++;

                inputs.forEach(input => {
                    input.name = input.name
                        .replace('DAY', day)
                        .replace('INDEX', currentIndex);

                    // Ensure values are properly set
                    if (input.type === 'time' && !input.value) {
                        input.value = '08:00'; // Default time if empty
                    }
                });

                container.appendChild(newPeriod);
            }

            // Delegate add period functionality
            document.getElementById('weekly-routine-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('add-period') || e.target.closest('.add-period')) {
                    const button = e.target.classList.contains('add-period') ? e.target : e.target.closest(
                        '.add-period');
                    addPeriod(button.dataset.day);
                }
            });

            // Delegate remove period functionality
            document.getElementById('weekly-routine-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-period') || e.target.closest('.remove-period')) {
                    const periodRow = e.target.closest('.period-row');
                    if (periodRow) {
                        periodRow.remove();
                    }
                }
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .period-row {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .day-card .card-header {
            background-color: #e9ecef;
        }

        .remove-period {
            line-height: 1;
        }

        .periods-container {
            padding-top: 15px;
        }
    </style>
@endpush
