<!DOCTYPE html>
<html>

<head>
    <title>{{ $branch->branch_name }} - {{ $classLevel->name }} Routine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        h2 {
            color: #555;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>{{ $branch->branch_name }}-2025</h1>
    <h2>Class-{{ $classLevel->name }} Routine</h2>
    <table>
        <thead>
            <tr>
                <th>Day</th>
                <th>Time</th>
                <th>Subject</th>
                <th>Teacher</th>
            </tr>
        </thead>
        <tbody>
            @php
                $groupedRoutine = $routine->groupBy('day_of_week');
            @endphp

            @foreach ($groupedRoutine as $day => $periods)
                @foreach ($periods as $index => $period)
                    <tr>
                        @if ($index === 0)
                            <td rowspan="{{ $periods->count() }}">{{ $day }}</td>
                        @endif
                        <td class="">{{ date('h:i A', strtotime($period->start_time)) }} -
                            {{ date('h:i A', strtotime($period->end_time)) }}</td>
                        <td>{{ $period->subject->sub_name }}</td>
                        <td>{{ $period->teacher->name }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
