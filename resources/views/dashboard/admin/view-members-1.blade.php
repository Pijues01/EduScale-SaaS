@extends('dashboard.layout.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    {{-- {{dd($members)}} --}}
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Members List</h4>

                <!-- Role Filter Dropdown -->
                <select id="roleFilter" class="form-select w-auto">
                    <option value="">Select Members</option>
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
                                        <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                    @endforeach
                                @endif
                                <th>Actions</th> {{-- Ensure Actions column is always present --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr>
                                    @foreach ($member->toArray() as $value)
                                        <td>{{ $value ?? '-' }}</td> {{-- Display "-" if value is null --}}
                                    @endforeach
                                    <td>
                                        {{-- {{$member->Student Id}} --}}
                                        {{-- <a href="{{ route('member.edit', $member->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a> --}}
                                            <a href="{{ route('member.edit', [
                                                'unick_id' => $role == 'student' ? $member->{"Student Id"} :
                                                             ($role == 'teacher' ? $member->{"Teacher Id"} :
                                                             ($role == 'parent' ? $member->{"Parent Id"} : $member->id))
                                            ]) }}" class="btn btn-primary btn-sm">Edit</a>

                                        {{-- <button class="btn btn-danger btn-sm deleteMember"
                                            data-id="{{ $member->id }}">Delete</button> --}}
                                            <button class="btn btn-danger btn-sm deleteMember"
                                                data-id="{{ $role == 'student' ? $member->{'Student Id'} :
                                                        ($role == 'teacher' ? $member->{'Teacher Id'} :
                                                        ($role == 'parent' ? $member->{'Parent Id'} : $member->id)) }}">
                                                Delete
                                            </button>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count(optional($members->first())->toArray() ?? []) + 1 }}"
                                        class="text-center">
                                        No members found
                                    </td>
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
            $('#membersTable').DataTable();

            // Handle Delete Button Click
            $('.deleteMember').click(function() {
                let memberId = $(this).data('id');
                if (confirm('Are you sure you want to delete this member?')) {
                    $.ajax({
                        url: '/admin/members/' + memberId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            location.reload();
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
