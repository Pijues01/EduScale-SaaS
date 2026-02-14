@extends('dashboard.layout.master')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Add Member</h4>
            </div>
            <div class="card-body">
                <!-- Tabs for Selection -->
                <ul class="nav nav-tabs mb-4" id="userTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#studentTab">Student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#parentTab">Parent</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#teacherTab">Teacher</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Student Form -->
                    <div id="studentTab" class="tab-pane fade show active" id="student">
                        <form method="POST"
                            action="{{ isset($role) && isset($member) ? route('memberUpdate', $member->unique_id) : route('memberregister') }}">
                            @csrf
                            @if (isset($role) && isset($member))
                                @method('PUT') {{-- Laravel requires PUT method for updates --}}
                            @endif
                            <input type="hidden" name="role" value="student">

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ isset($role) && $role == 'student' && isset($member) ? $member->name : old('name') }}"
                                    required>

                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="inputStateclass" class="form-label">Class</label>
                                    <select id="inputStateclass" class="form-control" name="class" required>
                                        <option selected>Choose...</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}"
                                                {{ isset($role) && $role == 'student' && isset($member) && $member->class == $i ? 'selected' : (old('class') == $i ? 'selected' : '') }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">School Name</label>
                                    <input type="text" class="form-control" name="school_name"
                                        value="{{ isset($role) && $role == 'student' && isset($member) ? $member->school_name : old('school_name') }}"
                                        required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone No.</label>
                                    <input type="tel" class="form-control" name="ph_no"
                                        value="{{ isset($role) && $role == 'student' && isset($member) ? $member->ph_no : old('ph_no') }}"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ isset($role) && $role == 'student' && isset($member) ? $member->email : old('email') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address"
                                        value="{{ isset($role) && $role == 'student' && isset($member) ? $member->address : old('address') }}"
                                        required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="inputState">Medium</label>
                                    <select id="inputStatemedium" class="form-control" name="medium" required>
                                        <option value="" disabled
                                            {{ old('medium') === null && !(isset($member) && $member->medium) ? 'selected' : '' }}>
                                            Choose...</option>
                                        <option value="english"
                                            {{ (isset($member) && $member->medium == 'english') || old('medium') == 'english' ? 'selected' : '' }}>
                                            English
                                        </option>
                                        <option value="bengali"
                                            {{ (isset($member) && $member->medium == 'bengali') || old('medium') == 'bengali' ? 'selected' : '' }}>
                                            Bengali
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        {{ isset($role) && $role == 'student' && isset($member) ? 'Create New Password' : 'Password' }}
                                    </label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Enter password">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        {{ isset($role) && $role == 'student' && isset($member) ? 'Confirm New Password' : 'Confirm Password' }}
                                    </label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        placeholder="Confirm password">
                                </div>
                            </div>



                            <button type="submit" class="btn btn-success w-100">
                                {{ isset($member) ? 'Update ' . ucfirst($member->role) : 'Register ' . ucfirst($role ?? '') }}
                            </button>

                        </form>
                    </div>

                    <!-- Parent Form -->
                    <div id="parentTab" class="tab-pane fade" id="parent">

                            <form method="POST"
                            action="{{ isset($role) && isset($member) ? route('memberUpdate', $member->unique_id) : route('memberregister') }}">
                            @csrf
                            @if (isset($role) && isset($member))
                                @method('PUT') {{-- Laravel requires PUT method for updates --}}
                            @endif

                            <input type="hidden" name="role" value="parent">

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                {{-- <input type="text" class="form-control" name="name" value="" required> --}}
                                <input type="text" class="form-control" name="name"
                                    value="{{ isset($role) && $role == 'parent' && isset($member) ? $member->name : old('name') }}"
                                    required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" name="ph_no"
                                           value="{{ isset($member) && $role == 'parent' ? $member->ph_no : old('ph_no') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email"
                                           value="{{ isset($member) && $role == 'parent' ? $member->email : old('email') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address"
                                           value="{{ isset($member) && $role == 'parent' ? $member->Address : old('address') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Child's ID</label>
                                    <input type="text" class="form-control" name="child_id"
                                           value="{{ isset($member) && $role == 'parent' ? $member->stu_id : old('child_id') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        {{ isset($member) ? 'Create New Password' : 'Password' }}
                                    </label>
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                           {{ !isset($member) ? 'required' : '' }}>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        {{ isset($member) ? 'Confirm New Password' : 'Confirm Password' }}
                                    </label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                           placeholder="Confirm Password" {{ !isset($member) ? 'required' : '' }}>
                                </div>
                            </div>




                            <button type="submit" class="btn btn-success w-100">
                                {{ isset($member) ? 'Update ' . ucfirst($member->role) : 'Register ' . ucfirst($role ?? '') }}
                            </button>

                        </form>
                    </div>

                    <!-- Teacher Form -->
                    <div id="teacherTab" class="tab-pane fade" id="teacher">

                        <form method="POST"
                            action="{{ isset($role) && isset($member) ? route('memberUpdate', $member->unique_id) : route('memberregister') }}">
                            @csrf
                            @if (isset($role) && isset($member))
                                @method('PUT') {{-- Laravel requires PUT method for updates --}}
                            @endif
                            <input type="hidden" name="role" value="teacher">

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                {{-- <input type="text" class="form-control" name="name" value="" required> --}}
                                <input type="text" class="form-control" name="name"
                                    value="{{ isset($role) && $role == 'teacher' && isset($member) ? $member->name : old('name') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="inputStatesubject">Subject</label>
                                <select id="inputStatesubject" class="form-control" name="subject_id" required>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" name="ph_no"
                                        value="{{ isset($member) && $role == 'teacher' ? $member->ph_no : old('ph_no') }}"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ isset($member) && $role == 'teacher' ? $member->email : old('email') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address"
                                    value="{{ isset($member) && $role == 'teacher' ? $member->address : old('address') }}"
                                    required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        {{ isset($member) && isset($role) && $role == 'teacher' ? 'Create New Password' : 'Password' }}
                                    </label>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        {{ isset($member) && isset($role) && $role == 'teacher' ? 'Confirm New Password' : 'Confirm Password' }}
                                    </label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        placeholder="Confirm Password">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                {{ isset($member) ? 'Update ' . ucfirst($member->role) : 'Register ' . ucfirst($role ?? '') }}
                            </button>

                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let activeTab = localStorage.getItem("activeTab");

            // Get the role from Laravel blade syntax
            let role = "{{ $role ?? '' }}";

            // Define role-to-tab mapping
            let roleTabMap = {
                "student": "#studentTab",
                "parent": "#parentTab",
                "teacher": "#teacherTab"
            };

            // If a role exists, set the active tab based on the role
            if (role && roleTabMap[role]) {
                activeTab = roleTabMap[role];
            }

            // Activate the corresponding tab
            if (activeTab) {
                let selectedTab = document.querySelector(`a[href="${activeTab}"]`);
                if (selectedTab) {
                    let bsTab = new bootstrap.Tab(selectedTab);
                    bsTab.show();
                }
            }

            // Store the last clicked tab in localStorage
            document.querySelectorAll("#userTabs a").forEach(tab => {
                tab.addEventListener("click", function(event) {
                    localStorage.setItem("activeTab", event.target.getAttribute("href"));
                });
            });

            // AJAX for subject dropdown
            $(document).ready(function() {
                $('#inputStatesubject').html('<option>Loading...</option>');
                $.ajax({
                    url: "{{ route('getSubjects') }}",
                    type: "GET",
                    success: function(response) {
                        let subjectDropdown = $('#inputStatesubject');
                        subjectDropdown.empty().append(
                            '<option value="" disabled>Choose Subject...</option>');

                        let selectedSubject =
                        "{{ isset($member) ? $member->subject : '' }}"; // Get subject ID from Blade

                        response.forEach(function(subject) {
                            let selected = (subject.id == selectedSubject) ?
                                'selected' : ''; // Compare in JS
                            subjectDropdown.append(
                                `<option value="${subject.id}" ${selected}>${subject.sub_name}</option>`
                            );
                        });
                    },
                    error: function() {
                        $('#inputStatesubject').html('<option>Error loading subjects</option>');
                    }
                });


            });

        });
    </script>
@endpush
