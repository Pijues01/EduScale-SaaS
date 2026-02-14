{{-- @extends('dashboard.layout.master')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">My Children</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($children as $child)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <img src="{{ asset($child->image ? 'storage/' . $child->image : 'blank-profile.png') }}"
                                        class="rounded-circle mb-3" width="100" height="100">
                                    <h5>{{ $child->name }}</h5>
                                    <p class="text-muted">ID: {{ $child->stu_id }}</p>
                                    <a href="{{ route('parent.classschedule', $child->stu_id) }}" class="btn btn-primary">
                                        View Class Schedule
                                    </a>
                                    <a href="{{ route('parent.attendance.calendar', $child->stu_id) }}"
                                        class="btn btn-primary">
                                        View Attendance
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection --}}

@extends('dashboard.layout.master')

@section('content')
    <div class="container py-4">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 font-weight-bold">My Children</h4>
                    <span class="badge badge-light rounded-pill">{{ count($children) }} Registered</span>
                </div>
            </div>
            <div class="card-body">
                @if (count($children) > 0)
                    <div class="row">
                        @foreach ($children as $child)
                            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition">
                                    <div class="card-body text-center p-4">
                                        <div class="avatar-wrapper mx-auto mb-3">
                                            <img src="{{ asset($child->image ? 'storage/' . $child->image : 'blank-profile.png') }}"
                                                class="rounded-circle border border-4 border-primary" width="120"
                                                height="120" alt="{{ $child->name }}'s profile picture">
                                            <div class="status-indicator bg-success"></div>
                                        </div>
                                        <h5 class="font-weight-bold mb-1">{{ $child->name }}</h5>
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-id-card mr-1"></i> ID: {{ $child->stu_id }}
                                        </p>
                                        {{-- <div class="d-flex justify-content-center gap-2 mt-3">
                                            <a href="{{ route('parent.classschedule', $child->stu_id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="fas fa-calendar-alt mr-1"></i> Schedule
                                            </a>
                                            <a href="{{ route('parent.attendance.calendar', $child->stu_id) }}"
                                                class="btn btn-sm btn-primary rounded-pill px-3">
                                                <i class="fas fa-clipboard-check mr-1"></i> Attendance
                                            </a>
                                        </div> --}}
                                        <div class="d-flex justify-content-center mt-3">
                                            <a href="{{ route('parent.classschedule', $child->stu_id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3 mr-2">
                                                <i class="fas fa-calendar-alt mr-1"></i> Schedule
                                            </a>
                                            <a href="{{ route('parent.attendance.calendar', $child->stu_id) }}"
                                                class="btn btn-sm btn-primary rounded-pill px-3">
                                                <i class="fas fa-clipboard-check mr-1"></i> Attendance
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-top-0 text-center pt-0">
                                        <small class="text-muted">
                                            Last updated: {{ now()->format('M j, Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <img src="{{ asset('svg/empty.svg') }}" class="img-fluid mb-3" width="200"
                                alt="No children">
                            <h5 class="font-weight-bold">No Children Registered</h5>
                            <p class="text-muted">Please contact the school administration to register your children.</p>
                            <a href="#" class="btn btn-primary mt-3">
                                <i class="fas fa-user-plus mr-1"></i> Register Child
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .card {
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .card-header.bg-gradient-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border-radius: 12px 12px 0 0 !important;
        }

        .hover-shadow-lg:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }

        .avatar-wrapper {
            position: relative;
            width: fit-content;
        }

        .status-indicator {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .empty-state {
            max-width: 500px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        // Add any interactive functionality here if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Add click animation to cards
            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('click', function(e) {
                    if (e.target.tagName !== 'A') {
                        this.classList.add('active');
                        setTimeout(() => this.classList.remove('active'), 300);
                    }
                });
            });
        });
    </script>
@endpush
