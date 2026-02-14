@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid px-0">
    <div class="card shadow-none border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h5 class="mb-0">Attendance Calendar</h5>
            <div class="d-flex">
                <span class="badge bg-white text-primary small">
                    <i class="fas fa-circle text-success mr-1"></i>P
                    <i class="fas fa-circle text-danger ml-2 mr-1"></i>A
                </span>
            </div>
        </div>
        <div class="card-body p-1">
            <div id="student-calendar"></div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    /* Mobile-first styles */
    #student-calendar {
        background: white;
        padding: 0;
    }

    .fc .fc-toolbar {
        flex-direction: column;
        padding: 0.5rem;
    }

    .fc .fc-toolbar-title {
        font-size: 1rem;
        margin: 0.5rem 0;
        order: 2;
    }

    .fc-toolbar-chunk {
        display: flex;
        width: 100%;
        justify-content: space-between;
        order: 1;
    }

    .fc .fc-button {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .fc .fc-daygrid-day-frame {
        min-height: 2.5rem;
    }

    .fc .fc-daygrid-day-number {
        font-size: 0.7rem;
        padding: 2px;
    }

    .fc-event {
        font-size: 0.6rem;
        padding: 0;
        margin: 0;
        border-radius: 2px;
    }

    /* Desktop overrides */
    @media (min-width: 768px) {
        .fc .fc-toolbar {
            flex-direction: row;
            padding: 1rem;
        }

        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            order: 1;
        }

        .fc-toolbar-chunk {
            width: auto;
            order: 2;
        }

        .fc .fc-button {
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
        }

        .fc .fc-daygrid-day-frame {
            min-height: 4rem;
        }

        .fc .fc-daygrid-day-number {
            font-size: 0.9rem;
            padding: 4px;
        }

        .fc-event {
            font-size: 0.8rem;
            padding: 1px 3px;
        }
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
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        footerToolbar: {
            center: 'today dayGridMonth,dayGridWeek'
        },
        height: 'auto',
        aspectRatio: 1,
        dateClick: function(info) {
            window.location.href = "{{ route('parent.attendance.date', ['id' => $studentId]) }}?date=" + info.dateStr;
        },
        events: [
            @foreach ($attendanceDays as $date => $status)
            {
                title: '{{ substr($status, 0, 1) }}', // Show just P/A
                start: '{{ $date }}',
                color: '{{ $status == 'Present' ? '#28a745' : '#dc3545' }}'
            },
            @endforeach
        ],
        eventContent: function(arg) {
            // Customize event display for mobile
            return {
                html: '<div class="fc-event-title">' + arg.event.title + '</div>'
            };
        }
    });

    function handleResponsive() {
        if (window.innerWidth < 768) {
            calendar.setOption('headerToolbar', {
                left: 'prev',
                center: 'title',
                right: 'next'
            });
            calendar.setOption('footerToolbar', {
                center: 'today dayGridMonth,dayGridWeek'
            });
        } else {
            calendar.setOption('headerToolbar', {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            });
            calendar.setOption('footerToolbar', false);
        }
        calendar.updateSize();
    }

    window.addEventListener('resize', handleResponsive);
    handleResponsive();
    calendar.render();
});
</script>
@endpush
