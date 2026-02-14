@extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5><i class="fas fa-comment-dots me-2"></i>Teacher Feedback</h5>
            </div>
            {{ auth()->user()->role }}

            <div class="card-body">
                {{-- <form action="{{ route('teacher.feedback.store') }}" method="POST">
                    @csrf --}}
                <form
                    action="{{ auth()->user()->role == 'teacher'
                        ? route('teacher.feedback.store')
                        : (auth()->user()->role == 'student'
                            ? route('student.feedback.store')
                            : (auth()->user()->role == 'parent'
                                ? route('parent.feedback.store')
                                : '#')) }}"
                    method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="type" required>
                            <option value="feedback">Feedback</option>
                            <option value="objection">Objection</option>
                            <option value="suggestion">Suggestion</option>
                        </select>
                    </div>
                    @if (auth()->user()->role === 'teacher')
                        <div class="mb-3">
                            <label class="form-label">Branch <small class="text-muted">(optional)</small></label>
                            <select class="form-select" name="branch_id">
                                <option value="">All Branches / General</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Submit
                    </button>
                </form>

                <hr class="my-4">

                <h5><i class="fas fa-history me-2"></i>Your Submissions</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $feedback->created_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $feedback->type == 'objection' ? 'danger' : 'primary' }}">
                                            {{ ucfirst($feedback->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $feedback->title }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $feedback->status == 'resolved' ? 'success' : 'warning' }}">
                                            {{ ucfirst($feedback->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No submissions yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $feedbacks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
