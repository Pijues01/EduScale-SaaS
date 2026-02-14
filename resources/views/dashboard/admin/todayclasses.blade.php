@extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Today's Classes</h4>
                <p>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
            </div>


             @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif



            <div class="card-body">
                @if ($branches->isEmpty())
                    <div class="alert alert-info">No classes scheduled for today.</div>
                @else
                    @foreach ($branches as $branch)
                        <div class="branch-section mb-4">
                            <div class="branch-header bg-light p-3 mb-3 rounded">
                                <h5 class="mb-0">{{ $branch->branch_name }}</h5>
                            </div>

                            @if ($branch->todayClasses->isEmpty())
                                <div class="alert alert-warning">No classes scheduled for this branch today.</div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Class</th>
                                                <th>Subject</th>
                                                <th>Teacher</th>
                                                <th>Time</th>
                                                <th>Attendence</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($branch->todayClasses as $index => $class)
                                                <tr
                                                    data-href="{{ route('class.students', ['branch_id' => $class->branch_id, 'class_level_id' => $class->class_level_id, 'routine_id' => $class->id]) }}">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $class->classLevel->name ?? 'N/A' }}</td>
                                                    <td>{{ $class->subject->sub_name ?? 'N/A' }}</td>
                                                    <td>{{ $class->teacher->name ?? 'N/A' }}</td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }} -
                                                        {{ \Carbon\Carbon::parse($class->end_time)->format('h:i A') }}
                                                    </td>

                                                    <td class="text-center">
                                                        <span
                                                            class="text-white text-center badge bg-{{ $class->is_complete == 1 ? 'success' : 'danger' }}">
                                                            {{ $class->is_complete == 1 ? 'Complete' : 'Due' }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <a href="{{ route('class.students', ['branch_id' => $class->branch_id, 'class_level_id' => $class->class_level_id, 'routine_id' => $class->id]) }}"
                                                            class="btn btn-sm btn-primary attendance-btn">
                                                            Attendance
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Make entire row clickable except when clicking the attendance button
            $('tbody tr').click(function(e) {
                // Don't navigate if clicking directly on the attendance button
                if (!$(e.target).closest('.attendance-btn').length) {
                    window.location = $(this).data('href');
                }
            }).css('cursor', 'pointer');

            // Style for hover effect
            $('tbody tr').hover(
                function() {
                    $(this).css('background-color', '#f8f9fa');
                },
                function() {
                    $(this).css('background-color', '');
                }
            );

            // Add some styling to branch sections
            $('.branch-section').each(function() {
                $(this).find('.branch-header').hover(
                    function() {
                        $(this).css('background-color', '#e9ecef');
                    },
                    function() {
                        $(this).css('background-color', '#f8f9fa');
                    }
                );
            });
        });
    </script>
@endpush
