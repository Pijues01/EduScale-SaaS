@extends('dashboard.layout.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="font-weight-bolder">{{ $branch->branch_name }}</h2>
            <h4 class="text-muted"><u>Class-{{ $classLevel->name }} Routine</u></h4>
        </div>
        <div>
            <a href="{{ route('admin.routine.download', ['branch' => $branch->id, 'classLevel' => $classLevel->id, 'type' => 'pdf']) }}"
               class="btn btn-danger mr-2">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>
            <button onclick="downloadAsImage()" class="btn btn-info">
                <i class="fas fa-image"></i> Download Image
            </button>
        </div>
    </div>

    <div class="table-responsive" id="routine-table">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($routine as $period)
                <tr>
                    <td>{{ $period->day_of_week }}</td>
                    <td>{{ date('h:i A', strtotime($period->start_time)) }} - {{ date('h:i A', strtotime($period->end_time)) }}</td>
                    <td>{{ $period->subject->sub_name }}</td>
                    <td>{{ $period->teacher->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
function downloadAsImage() {
    // Get the branch name and class level
    const branchName = "{{ $branch->branch_name }}";
    const className = "{{ $classLevel->name }}";
    
    // Create a filename with branch and class
    const filename = `${branchName}-${className}-routine`.replace(/\s+/g, '-').toLowerCase();
    
    // Capture the entire container including the header
    html2canvas(document.querySelector("#routine-table"), {
        scale: 2, // Higher quality
        logging: false,
        useCORS: true,
        allowTaint: true,
        windowHeight: document.querySelector("#routine-table").scrollHeight
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = `${filename}.jpg`;
        link.href = canvas.toDataURL('image/jpeg', 1.0);
        link.click();
    });
}
</script>
@endpush

@push('css')
<style>
    /* Ensure the table looks good in the image */
    .table {
        width: 100%;
    }
    .table-responsive {
        background: white;
        padding: 20px;
        border-radius: 5px;
    }
    .thead-dark th {
        background-color: #343a40 !important;
        color: white !important;
    }
</style>
@endpush