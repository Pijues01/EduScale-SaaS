@extends('dashboard.layout.master')

@section('content')
<div class="container">
    <h2>Class Routines</h2>

    @foreach($routines as $branchName => $classes)
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4>{{ $branchName }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($classes as $class)
                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.routine.view', [
                        'b_id' => $class->branch_id,
                        'c_id' => $class->class_level_id
                    ]) }}"
                       class="btn btn-outline-secondary btn-block">
                        Class : {{ $class->class_name }}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach

    @if($routines->isEmpty())
    <div class="alert alert-info text-center mt-5" role="alert">
        No routines available for any class.
    </div>
    @endif
</div>
@endsection
