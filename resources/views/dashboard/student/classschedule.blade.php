@extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header text-center pb-0">
                        <h3>Class Schedule</h3>
                        <p class="text-sm mb-0">
                            Class-{{ $student->name }} -•-  {{ auth()->user()->name }}
                        </p>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#daily"
                                        role="tab" aria-controls="daily" aria-selected="true">
                                        Daily View
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#weekly" role="tab"
                                        aria-controls="weekly" aria-selected="false">
                                        Weekly View
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <!-- Daily View Tab -->
                            <div class="tab-pane fade show active" id="daily" role="tabpanel"
                                aria-labelledby="daily-tab">
                                <div class="row px-4 mb-3">
                                    <div class="col-md-6">
                                        <form method="GET" action="{{ route('student.classschedule') }}">
                                            <div class="input-group">
                                                <select name="day" class="form-select" onchange="this.form.submit()">
                                                    @foreach ($days as $dayOption)
                                                        <option value="{{ $dayOption }}"
                                                            {{ $currentDay == $dayOption ? 'selected' : '' }}>
                                                            {{ $dayOption }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                @if ($dailySchedule->count() > 0)
                                    <div class="table-responsive p-4">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Time</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Subject</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Teacher</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dailySchedule as $routine)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">
                                                                        {{ date('h:i A', strtotime($routine->start_time)) }}
                                                                        - {{ date('h:i A', strtotime($routine->end_time)) }}
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">
                                                                        {{ $routine->subject->sub_name ?? 'N/A' }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">
                                                                        {{ $routine->teacher->name ?? 'N/A' }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info mx-4">
                                        No classes scheduled for {{ $currentDay }}.
                                    </div>
                                @endif
                            </div>

                            <!-- Weekly View Tab -->
                            <div class="tab-pane fade" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                                <div class="table-responsive p-4">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Day</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Time</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Subject</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Teacher</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($days as $day)
                                                @if (isset($weeklySchedule[$day]) && $weeklySchedule[$day]->count() > 0)
                                                    @foreach ($weeklySchedule[$day] as $routine)
                                                        <tr>
                                                            @if ($loop->first)
                                                                <td rowspan="{{ $weeklySchedule[$day]->count() }}">
                                                                    <div class="d-flex px-2 py-1">
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center">
                                                                            <h6 class="mb-0 text-sm">{{ $day }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            @endif
                                                            <td>
                                                                <div class="d-flex px-2 py-1">
                                                                    <div class="d-flex flex-column justify-content-center">
                                                                        <h6 class="mb-0 text-sm">
                                                                            {{ date('h:i A', strtotime($routine->start_time)) }}
                                                                            -
                                                                            {{ date('h:i A', strtotime($routine->end_time)) }}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex px-2 py-1">
                                                                    <div class="d-flex flex-column justify-content-center">
                                                                        <h6 class="mb-0 text-sm">
                                                                            {{ $routine->subject->sub_name ?? 'N/A' }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex px-2 py-1">
                                                                    <div class="d-flex flex-column justify-content-center">
                                                                        <h6 class="mb-0 text-sm">
                                                                            {{ $routine->teacher->name ?? 'N/A' }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">{{ $day }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td colspan="3">
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">No classes</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
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
    </div>
@endsection

@push('js')
<!-- In your layout file's head section -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activate the correct tab based on URL hash
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash) {
                const tab = document.querySelector(`[href="${window.location.hash}"]`);
                if (tab) {
                    const tabInstance = new bootstrap.Tab(tab);
                    tabInstance.show();
                }
            }
        });
    </script>
@endpush

