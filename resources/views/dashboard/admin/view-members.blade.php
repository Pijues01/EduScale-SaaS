@extends('dashboard.layout.master')
@php
    use Illuminate\Support\Facades\Storage;
@endphp

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .img-thumbnail {
            max-width: 50px;
            height: auto;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Members List</h4>
                <select id="roleFilter" class="form-select w-auto">
                    {{-- <option value="">All Members</option> --}}
                    <option value="student" {{ $role == 'student' ? 'selected' : '' }}>Students</option>
                    <option value="teacher" {{ $role == 'teacher' ? 'selected' : '' }}>Teachers</option>
                    <option value="parent" {{ $role == 'parent' ? 'selected' : '' }}>Parents</option>
                </select>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="membersTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                @if ($members->isNotEmpty())
                                    @foreach (array_keys($members->first()->toArray()) as $key)
                                        @if (!in_array($key, ['id', 'created_at', 'updated_at']))
                                            <th>{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                        @endif
                                    @endforeach
                                    <th>Actions</th>
                                @else
                                    <th>No members found</th>
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr>
                                    @foreach ($member->toArray() as $key => $value)
                                        @if (!in_array($key, ['id', 'created_at', 'updated_at']))
                                            {{-- <td>
                                                @if (strpos($key, 'Image') !== false && $value)
                                                    <img src="{{ asset('storage/' . str_replace('public/', '', $value)) }}"
                                                        class="img-thumbnail" alt="Profile Image" width="80">
                                                @else --}}
                                                    {{-- {{ $value ?? '-' }} --}}
                                                    {{-- {!! $value ??
                                                        '<img width="80" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="Default Profile">' !!} --}}
                                                {{-- @endif
                                            </td> --}}

                                            <td>
                                                @if (strpos(strtolower($key), 'image') !== false)
                                                    @if ($value)
                                                        <img src="{{ asset('storage/' . str_replace('public/', '', $value)) }}"
                                                            class="img-thumbnail" alt="Profile Image" width="80">
                                                    @else
                                                        <img width="80"
                                                            src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                                            alt="Default Profile">
                                                    @endif
                                                @else
                                                    {{ $value ?? '-' }}
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                    <td>
                                        <a href="{{ route('member.edit', [
                                            'unick_id' =>
                                                $role == 'student'
                                                    ? $member->{'Student Id'}
                                                    : ($role == 'teacher'
                                                        ? $member->{'Teacher Id'}
                                                        : ($role == 'parent'
                                                            ? $member->{'Parent Id'}
                                                            : '')),
                                        ]) }}"
                                            class="btn btn-primary btn-sm">Edit</a>

                                        <button class="btn btn-danger btn-sm deleteMember"
                                            data-id="{{ $role == 'student'
                                                ? $member->{'Student Id'}
                                                : ($role == 'teacher'
                                                    ? $member->{'Teacher Id'}
                                                    : ($role == 'parent'
                                                        ? $member->{'Parent Id'}
                                                        : '')) }}"
                                            data-role="{{ $role }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">No members found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#membersTable').DataTable({
                responsive: true
            });

            // Handle Delete Button Click
            $(document).on('click', '.deleteMember', function() {
                let memberId = $(this).data('id');
                let role = $(this).data('role');

                if (confirm('Are you sure you want to delete this member?')) {
                    $.ajax({
                        url: '/admin/members/' + memberId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            role: role
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert(response.message || 'Error deleting member');
                            }
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });

            // Handle Role Filter Change
            $('#roleFilter').change(function() {
                let selectedRole = $(this).val();

                if (selectedRole) {
                    let url = "{{ url('/admin/members') }}/" + selectedRole;
                    window.location.href = url;
                }
            });
        });
    </script>
@endpush
