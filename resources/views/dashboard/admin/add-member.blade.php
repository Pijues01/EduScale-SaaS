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
                            action="{{ isset($role) && isset($member) ? route('memberUpdate', $member->unique_id) : route('memberregister') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($role) && isset($member))
                                @method('PUT') {{-- Laravel requires PUT method for updates --}}
                            @endif
                            <input type="hidden" name="role" value="student">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ isset($role) && $role == 'student' && isset($member) ? $member->name : old('name') }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Image</label>
                                    @if (isset($member->image_url))
                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <input type="file" class="form-control" name="image" id="imageInput">
                                                <small class="text-muted">Leave blank to keep current image</small>
                                            </div>
                                            <div class="col-md-6">
                                                <img src="{{ $member->image_url }}" alt="Current Image"
                                                    style="max-width: 60px; max-height: 60px;" class="img-thumbnail">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="remove_image"
                                                        id="removeImage">
                                                    <label class="form-check-label" for="removeImage">
                                                        Remove current image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <input type="file" class="form-control" name="image" id="imageInput">
                                        <small class="text-muted">Leave blank to keep current image</small>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                {{-- <div class="col-md-6 mb-3">
                                    <label for="inputClass" class="form-label">Class</label>
                                    <select id="inputClass" class="form-control" name="class_level_id" required>
                                        <option value="" disabled>Choose...</option>
                                        @foreach ($classLevels as $class)
                                            <option value="{{ $class->id }}"
                                                @if ((int) $member->class === (int) $class->id) selected @endif>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_level_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                <div class="col-md-6 mb-3">
                                    <label for="inputClass" class="form-label">Class</label>
                                    <select id="inputClass" class="form-control" name="class_level_id" required>
                                        <option value="" disabled {{ old('class_level_id') ? '' : 'selected' }}>
                                            Choose...</option>
                                        @foreach ($classLevels as $class)
                                            <option value="{{ $class->id }}"
                                                @if (
                                                    (isset($role) && $role == 'student' && isset($member) && (int) $member->class_level_id === (int) $class->id) ||
                                                        old('class_level_id') == $class->id) selected @endif>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_level_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address"
                                        value="{{ isset($role) && $role == 'student' && isset($member) ? $member->address : old('address') }}"
                                        required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="inputBranch">Branch</label>
                                    <select id="inputBranch" class="form-control" name="branch_id" required>
                                        <option value="" disabled
                                            {{ old('branch_id') === null && !(isset($member) && $member->branch_id) ? 'selected' : '' }}>
                                            Choose...
                                        </option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ (isset($member) && $member->branch_id == $branch->id) || old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                    <!-- Parent Form -->
                    <div id="parentTab" class="tab-pane fade" id="parent">
                        <form method="POST"
                            action="{{ isset($role) && isset($member) ? route('memberUpdate', $member->unique_id) : route('memberregister') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($role) && isset($member))
                                @method('PUT')
                            @endif
                            <input type="hidden" name="role" value="parent">
                            <!-- Add this hidden input at the top of your parent form -->
                            <input type="hidden" name="child_id[]" value="" disabled>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ isset($role) && $role == 'parent' && isset($member) ? $member->name : old('name') }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" name="ph_no"
                                        value="{{ isset($member) && $role == 'parent' ? $member->ph_no : old('ph_no') }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ isset($member) && $role == 'parent' ? $member->email : old('email') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address"
                                        value="{{ isset($member) && $role == 'parent' ? $member->Address : old('address') }}"
                                        required>
                                </div>
                            </div>

                            <!-- Child/Student Selection Section -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Children/Students</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Search Filters -->
                                    <div class="row mb-3">
                                        <div class="col-md-5">
                                            <label class="form-label">Branch</label>
                                            <select class="form-control search-filter" id="childBranchFilter">
                                                <option value="">All Branches</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->branch_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Class</label>
                                            <select class="form-control search-filter" id="childClassFilter">
                                                <option value="">All Classes</option>
                                                @foreach ($classLevels as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary w-100"
                                                id="searchChildrenBtn">Search</button>
                                        </div>
                                    </div>

                                    <!-- Search Results -->
                                    <div class="table-responsive mb-3">
                                        {{-- <table class="table table-bordered" id="childrenResultsTable"
                                            style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th width="50">Select</th>
                                                    <th>Name</th>
                                                    <th>ID</th>
                                                    <th>Class</th>
                                                    <th>Branch</th>
                                                </tr>
                                            </thead>
                                            <tbody id="childrenResultsBody">
                                                <!-- Results will be populated by AJAX -->
                                            </tbody>
                                        </table> --}}
                                        <table class="table table-bordered" id="childrenResultsTable"
                                            style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th width="50">Select</th>
                                                    <th width="70">Image</th>
                                                    <th>Name</th>
                                                    <th>ID</th>
                                                    <th>Class</th>
                                                    <th>Branch</th>
                                                </tr>
                                            </thead>
                                            <tbody id="childrenResultsBody">
                                                <!-- Results will be populated by AJAX -->
                                            </tbody>
                                        </table>
                                        <div class="text-end mb-3">
                                            <button type="button" class="btn btn-primary" id="addSelectedChildrenBtn">
                                                <i class="fas fa-plus"></i> Add Selected Children
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Selected Children -->
                                    <div class="selected-children-container">
                                        <h6>Selected Children:</h6>
                                        <div id="selectedChildrenList" class="mb-3">
                                            @if (isset($member) && $role == 'parent' && !empty($member->child_id))
                                                @php
                                                    $childIds = explode(',', $member->child_id);
                                                    $children = \App\Models\Student::whereIn(
                                                        'stu_id',
                                                        $childIds,
                                                    )->get();
                                                @endphp
                                                @foreach ($children as $child)
                                                    <div class="selected-child-item badge bg-secondary me-2 mb-2 p-2"
                                                        data-child-id="{{ $child->stu_id }}">
                                                        {{ $child->name }} ({{ $child->stu_id }})
                                                        <input type="hidden" name="child_id[]"
                                                            value="{{ $child->stu_id }}">
                                                        <button type="button"
                                                            class="btn-close btn-close-white ms-2 remove-child"
                                                            style="font-size: 0.5rem;"></button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label
                                        class="form-label">{{ isset($member) ? 'Create New Password' : 'Password' }}</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                        {{ !isset($member) ? 'required' : '' }}>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label
                                        class="form-label">{{ isset($member) ? 'Confirm New Password' : 'Confirm Password' }}</label>
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
                            action="{{ isset($role) && isset($member) ? route('memberUpdate', $member->unique_id) : route('memberregister') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($role) && isset($member))
                                @method('PUT') {{-- Laravel requires PUT method for updates --}}
                            @endif
                            <input type="hidden" name="role" value="teacher">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    {{-- <input type="text" class="form-control" name="name" value="" required> --}}
                                    <input type="text" class="form-control" name="name"
                                        value="{{ isset($role) && $role == 'teacher' && isset($member) ? $member->name : old('name') }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
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

@push('css')
    <style>
        .selected-child-item {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .remove-child {
            cursor: pointer;
        }

        #childrenResultsTable {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
@endpush

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
                        // subjectDropdown.empty().append(
                        //     '<option value="" disabled>Choose Subject...</option>'); // Note: In teacher subject select "Bengali was by default selected" thats why disabled option is not used here
                        subjectDropdown.empty().append(
                            '<option value="" >Choose Subject...</option>');

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

    <script>
        $(document).ready(function() {
            // Search for children
            $('#searchChildrenBtn').click(function() {
                const branchId = $('#childBranchFilter').val();
                const classId = $('#childClassFilter').val();

                $.ajax({
                    url: "{{ route('searchStudents') }}",
                    type: "GET",
                    data: {
                        branch_id: branchId,
                        class_level_id: classId
                    },
                    success: function(response) {
                        const resultsBody = $('#childrenResultsBody');
                        resultsBody.empty();

                        if (response.length > 0) {
                            response.forEach(function(student) {
                                // Determine image URL or placeholder
                                let imageUrl = student.image ?
                                    "{{ asset('storage') }}/" + student.image :
                                    "{{ asset('https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png') }}";

                                resultsBody.append(`
                <tr>
                    <td>
                        <input type="checkbox" class="child-checkbox" value="${student.stu_id}"
                            data-name="${student.name}"
                            data-class="${student.class_level ? student.class_level.name : ''}"
                            data-branch="${student.branch ? student.branch.branch_name : ''}">
                    </td>
                    <td>
                        <img src="${imageUrl}" alt="${student.name}"
                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    </td>
                    <td>${student.name}</td>
                    <td>${student.stu_id}</td>
                    <td>${student.class_level ? student.class_level.name : ''}</td>
                    <td>${student.branch ? student.branch.branch_name : ''}</td>
                </tr>
            `);
                            });
                            $('#childrenResultsTable').show();
                        } else {
                            resultsBody.append(
                                '<tr><td colspan="6" class="text-center">No students found</td></tr>'
                            );
                            $('#childrenResultsTable').show();
                        }
                    },
                    error: function() {
                        alert('Error searching for students');
                    }
                });
            });

            // Add selected children
            // $(document).on('click', '#addSelectedChildrenBtn', function() {
            //     $('.child-checkbox:checked').each(function() {
            //         const childId = $(this).val();
            //         const childName = $(this).data('name');

            //         // Check if already selected
            //         if ($(`.selected-child-item[data-child-id="${childId}"]`).length === 0) {
            //             $('#selectedChildrenList').append(`
        //             <div class="selected-child-item badge bg-secondary me-2 mb-2 p-2" data-child-id="${childId}">
        //                 ${childName} (${childId})
        //                 <input type="hidden" name="child_id[]" value="${childId}">
        //                 <button type="button" class="btn-close btn-close-white ms-2 remove-child" style="font-size: 0.5rem;"></button>
        //             </div>
        //         `);
            //         }
            //     });

            //     // Uncheck all checkboxes
            //     $('.child-checkbox').prop('checked', false);
            // });
            $('#addSelectedChildrenBtn').click(function() {
                let addedCount = 0;

                $('.child-checkbox:checked').each(function() {
                    const childId = $(this).val();
                    const childName = $(this).data('name');
                    const childClass = $(this).data('class');
                    const childBranch = $(this).data('branch');

                    // Check if already selected
                    if ($(`.selected-child-item[data-child-id="${childId}"]`).length === 0) {
                        $('#selectedChildrenList').append(`
                    <div class="selected-child-item badge bg-secondary me-2 mb-2 p-2" data-child-id="${childId}">
                        ${childName} (${childId})
                        <small class="d-block">${childClass} - ${childBranch}</small>
                        <input type="hidden" name="child_id[]" value="${childId}">
                        <button type="button" class="btn-close btn-close-white ms-2 remove-child" style="font-size: 0.5rem;"></button>
                    </div>
                `);
                        addedCount++;
                    }
                });

                // Uncheck all checkboxes
                $('.child-checkbox').prop('checked', false);

                if (addedCount > 0) {
                    // Show success feedback
                    const alert = $(`
                <div class="alert alert-success alert-dismissible fade show">
                    Added ${addedCount} children
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
                    $('.card-body').prepend(alert);
                    alert.delay(3000).fadeOut();
                }
            });


            // Remove child
            $(document).on('click', '.remove-child', function() {
                $(this).parent().remove();
            });

            // Add all children
            $('#addAllChildrenBtn').click(function() {
                $('.child-checkbox').each(function() {
                    const childId = $(this).val();
                    const childName = $(this).data('name');

                    if ($(`.selected-child-item[data-child-id="${childId}"]`).length === 0) {
                        $('#selectedChildrenList').append(`
                        <div class="selected-child-item badge bg-secondary me-2 mb-2 p-2" data-child-id="${childId}">
                            ${childName} (${childId})
                            <input type="hidden" name="child_id[]" value="${childId}">
                            <button type="button" class="btn-close btn-close-white ms-2 remove-child" style="font-size: 0.5rem;"></button>
                        </div>
                    `);
                    }
                });
            });
        });

        // Add this to your JavaScript
       // Update your form submission handler
$('form').submit(function(e) {
    if ($('#parentTab').hasClass('active')) {
        const selectedCount = $('#selectedChildrenList').children().length;
        if (selectedCount === 0) {
            e.preventDefault();
            // Create a nicer error message
            const errorDiv = $(`
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error:</strong> Please select and add at least one child
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
            $('.card-body').prepend(errorDiv);
            // Scroll to the error message
            $('html, body').animate({
                scrollTop: errorDiv.offset().top - 20
            }, 500);
            return false;
        }
    }
    return true;
});
    </script>


    {{-- For Image upload in Edit: --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            const removeCheckbox = document.getElementById('removeImage');

            if (imageInput && removeCheckbox) {
                imageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        removeCheckbox.checked = false;
                    }
                });

                removeCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        imageInput.value = '';
                    }
                });
            }
        });
    </script>
@endpush
