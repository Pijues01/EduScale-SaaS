@extends('dashboard.layout.master')

@section('content')
<div class="container mt-4">
    <h2>Add New Job</h2>

    <form action="{{ route('admin.jobs.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Job Type</label>
            <select name="type" class="form-control" required>
                <option value="">Choose...</option>
                <option value="Full-Time">Full-Time</option>
                <option value="Part-Time">Part-Time</option>
                <option value="Remote">Remote</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Degree (Optional)</label>
            <input type="text" name="degree" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Save Job</button>
    </form>
</div>
@endsection
