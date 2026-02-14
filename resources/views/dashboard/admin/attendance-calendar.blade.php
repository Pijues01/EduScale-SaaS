@extends('dashboard.layout.master')

@section('content')
    <div class="container">
        <h2>Attendance Calendar</h2>
        <div class="card">
            <div class="card-body">
                <div id="attendance-calendar"></div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
@endpush

@push('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('attendance-calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dateClick: function(info) {
                    window.location.href = "{{ route('attendance.date-classes') }}?date=" + info
                    .dateStr;
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                events: [
                    @foreach ($attendanceDays as $day)
                        {
                            title: '{{ $day->present }} Present',
                            start: '{{ $day->date }}',
                            color: '#28a745'
                        },
                    @endforeach
                ]
            });
            calendar.render();
        });
    </script>
@endpush
