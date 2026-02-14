<!DOCTYPE html>
<html>
<head>
    <title>{{ $branch->branch_name }} - {{ $classLevel->name }} Routine</title>
    <style>
        body { font-family: Arial, sans-serif; background: white; padding: 20px; }
        h1 { color: #333; text-align: center; margin-bottom: 5px; }
        h2 { color: #555; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>{{ $branch->branch_name }}</h1>
    <h2>{{ $classLevel->name }} Routine</h2>
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
            @foreach($routine as $period)
            <tr>
                <td>{{ $period->day_of_week }}</td>
                <td>{{ date('h:i A', strtotime($period->start_time)) }} - {{ date('h:i A', strtotime($period->end_time)) }}</td>
                <td>{{ $period->subject->sub_name }}</td>
                <td>{{ $period->teacher->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
