@extends('dashboard.layout.master')

@section('content')
    <div class="container">
        <!-- This div contains the elements we want to capture -->
        <div id="full-routine-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="font-weight-bolder">{{ $branch->branch_name }}-2025</h2>
                    <h4 class="text-muted"><u>Class-{{ $classLevel->name }} Routine</u></h4>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $groupedRoutine = $routine->groupBy('day_of_week');
                        @endphp

                        @foreach ($groupedRoutine as $day => $periods)
                            @foreach ($periods as $index => $period)
                            {{-- {{ dd($period) }} --}}

                                <tr>
                                    @if ($index === 0)
                                        <td rowspan="{{ $periods->count() }}" class="text-center align-middle">
                                            {{ $day }}</td>
                                    @endif
                                    <td class="">{{ date('h:i A', strtotime($period->start_time)) }} -
                                        {{ date('h:i A', strtotime($period->end_time)) }}</td>
                                    <td>{{ $period->subject->sub_name }}</td>
                                    <td>{{ $period->teacher->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.routine.edit', $period->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.routine.delete', $period->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                {{-- <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routine as $period)
                            <tr>
                                <td>{{ $period->day_of_week }}</td>
                                <td>{{ date('h:i A', strtotime($period->start_time)) }} -
                                    {{ date('h:i A', strtotime($period->end_time)) }}</td>
                                <td>{{ $period->subject->sub_name }}</td>
                                <td>{{ $period->teacher->name }}</td>
                                <td>
                                    <a href="{{ route('admin.routine.edit', $period->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.routine.delete', $period->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}
            </div>
        </div>

        <!-- Download buttons placed outside the capture area -->
        <div class="mt-4 mb-4 text-center">
            <a href="{{ route('admin.routine.download', ['branch' => $branch->id, 'classLevel' => $classLevel->id, 'type' => 'pdf']) }}"
                class="btn btn-danger mr-2">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>
            <button onclick="downloadAsImage()" class="btn btn-info">
                <i class="fas fa-image"></i> Download Image
            </button>
            {{-- <button onclick="window.print()" class="btn btn-secondary">
                <i class="fas fa-print"></i> Print
            </button> --}}
        </div>
    </div>
@endsection

@push('js')
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        function downloadAsImage() {
            // Get elements to capture
            const container = document.querySelector("#full-routine-container");
            const branchName = "{{ $branch->branch_name }}";
            const className = "{{ $classLevel->name }}";
            const filename = `${branchName}-${className}-routine`.replace(/\s+/g, '-').toLowerCase();

            // Capture with html2canvas
            html2canvas(container, {
                scale: 2,
                logging: false,
                useCORS: true,
                allowTaint: true,
                windowHeight: container.scrollHeight + 100, // Extra space
                onclone: (clonedDoc) => {
                    // Optional: Enhance styling for the captured version
                    clonedDoc.getElementById('full-routine-container').style.padding = '20px';
                    clonedDoc.getElementById('full-routine-container').style.background = 'white';
                }
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
        /* Styles for the captured content */
        #full-routine-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .font-weight-bolder {
            font-weight: 800 !important;
            color: #343a40;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .table {
            width: 100%;
        }

        .thead-dark th {
            background-color: #343a40 !important;
            color: white !important;
        }
    </style>
@endpush
