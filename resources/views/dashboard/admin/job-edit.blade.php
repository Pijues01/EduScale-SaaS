@extends('dashboard.layout.master')

@section('content')
<div class="container mt-4">
    <h2>Edit Job</h2>

    <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $job->title }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="{{ $job->location }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Job Type</label>
            <select name="type" class="form-control" required>
                <option value="Full-Time" {{ $job->type == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                <option value="Part-Time" {{ $job->type == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                <option value="Remote" {{ $job->type == 'Remote' ? 'selected' : '' }}>Remote</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Degree (Optional)</label>
            <input type="text" name="degree" class="form-control" value="{{ $job->degree }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ $job->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Update Job</button>
    </form>
</div>
@endsection
