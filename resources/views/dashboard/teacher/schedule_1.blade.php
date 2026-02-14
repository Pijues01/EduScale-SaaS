@extends('dashboard.layout.master')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">My Teaching Schedule</h2>
            <div class="btn-group" role="group">
                <a href="?view=daily" class="btn btn-outline-primary {{ $viewType === 'daily' ? 'active' : '' }}">Daily</a>
                <a href="?view=weekly" class="btn btn-outline-primary {{ $viewType === 'weekly' ? 'active' : '' }}">Weekly</a>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                @if ($viewType === 'daily')
                    <h4 class="mb-3">Today's Schedule ({{ now()->format('l, F j') }})</h4>
                @elseif($viewType === 'weekly')
                    <h4 class="mb-3">Weekly Schedule (Week {{ now()->weekOfYear }})</h4>
                @else
                    <h4 class="mb-3">Monthly Schedule ({{ now()->format('F Y') }})</h4>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle">
                        <thead class="thead-light">
                            <tr>
                                @if ($viewType === 'weekly')
                                    <th>Day</th>
                                @elseif($viewType === 'monthly')
                                    <th>Date</th>
                                @endif
                                <th>Time</th>
                                <th>Branch</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($schedules->isEmpty())
                                <tr>
                                    <td colspan="{{ $viewType === 'daily' ? 4 : 5 }}" class="text-center text-muted">No
                                        classes scheduled</td>
                                </tr>
                            @else
                                @php $grouped = $schedules->groupBy('day_of_week'); @endphp

                                @foreach ($grouped as $day => $daySchedules)
                                    @foreach ($daySchedules as $index => $schedule)
                                        <tr class="clickable-row"
                                            data-href="{{ route('students.byClass', ['b_id' => $schedule->branch_id, 'c_id' => $schedule->class_level_id]) }}">
                                            @if ($index === 0 && $viewType === 'weekly')
                                                <td class="text-center align-middle" rowspan="{{ $daySchedules->count() }}">
                                                    {{ $day }}</td>
                                            @endif
                                            <td>{{ date('h:i A', strtotime($schedule->start_time)) }} -
                                                {{ date('h:i A', strtotime($schedule->end_time)) }}</td>
                                            <td>{{ $schedule->branch->branch_name }}</td>
                                            <td>{{ $schedule->classLevel->name }}</td>
                                            <td>{{ $schedule->subject->sub_name }}</td>
                                            <td>
                                                <a href="{{ route('students.byClass', ['b_id' => $schedule->branch_id, 'c_id' => $schedule->class_level_id]) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> View Students
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Make table rows clickable --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".clickable-row").forEach(row => {
                row.addEventListener("click", function() {
                    const href = this.getAttribute("data-href");
                    if (href) {
                        window.location.href = href;
                    }
                });
                row.style.cursor = "pointer";
            });
        });
    </script>
@endsection
