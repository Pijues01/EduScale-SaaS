@extends('dashboard.layout.master')

@section('content')
    {{-- <div class="container">
        <h4>My Attendance Calendar</h4>
        <div id="student-calendar"></div>
    </div> --}}
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">My Attendance Calendar</h4>
            </div>
            <div class="card-body">
                <div id="student-calendar"></div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <style>
        #student-calendar {
            background: white;
            border-radius: 8px;
            padding: 15px;
        }

        .fc-daygrid-day:hover {
            cursor: pointer;
            background-color: #f8f9fa;
        }

        .fc-event {
            cursor: pointer;
            font-size: 0.85em;
            padding: 2px 4px;
            border-radius: 4px;
        }

        .fc-event-present {
            background-color: #28a745;
            border-color: #28a745;
        }

        .fc-event-absent {
            background-color: #dc3545;
            border-color: #dc3545;
        }
    </style>
@endpush
@push('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('student-calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dateClick: function(info) {
                    window.location.href =
                        "{{ route('parent.attendance.date', ['id' => $studentId]) }}?date=" + info
                        .dateStr;
                },
                events: [
                    @foreach ($attendanceDays as $date => $status)
                        {
                            title: '{{ $status }}',
                            start: '{{ $date }}',
                            color: '{{ $status == 'Present' ? '#28a745' : '#dc3545' }}'
                        },
                    @endforeach
                ]
            });
            calendar.render();
        });
    </script>
@endpush
