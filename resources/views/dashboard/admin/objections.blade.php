@extends('dashboard.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manage Objections</h4>
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addObjectionModal">
                    <i class="fas fa-plus"></i> Add New Objection
                </button>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Search Form -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form action="{{ route('admin.objections') }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search"
                                    placeholder="Search by name, ID, branch or class" value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                @if (request('search'))
                                    <a href="{{ route('admin.objections') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>


                <div class="container-fluid">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Manage Objections</h4>
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addObjectionModal">
                                <i class="fas fa-plus"></i> Add New Objection
                            </button>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <!-- Tabs Navigation -->
                            <ul class="nav nav-tabs mb-4" id="objectionsTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="admin-tab" data-bs-toggle="tab"
                                        data-bs-target="#admin-objections" type="button" role="tab">
                                        Admin Objections
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="teacher-tab" data-bs-toggle="tab"
                                        data-bs-target="#teacher-objections" type="button" role="tab">
                                        Teacher Objections
                                    </button>
                                </li>
                            </ul>

                            <!-- Search Form -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <form action="{{ route('admin.objections') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search"
                                                placeholder="Search by name, ID, branch or class"
                                                value="{{ request('search') }}">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                            @if (request('search'))
                                                <a href="{{ route('admin.objections') }}" class="btn btn-outline-secondary">
                                                    <i class="fas fa-times"></i> Clear
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Tab Content -->
                            <div class="tab-content" id="objectionsTabContent">
                                <!-- Admin Objections Tab -->
                                <div class="tab-pane fade show active" id="admin-objections" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Student</th>
                                                    <th>Class</th>
                                                    <th>Branch</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($objections->where('teacher_id', null) as $objection)
                                                    <tr>
                                                        <td>{{ $objection->student->name ?? 'N/A' }}
                                                            ({{ $objection->student->stu_id ?? '' }})
                                                        </td>
                                                        <td>{{ $objection->classLevel->name ?? 'N/A' }}</td>
                                                        <td>{{ $objection->branch->branch_name ?? 'N/A' }}</td>
                                                        <td>{{ $objection->title }}</td>
                                                        <td>{{ Str::limit($objection->description, 50) }}</td>
                                                        <td>
                                                            @if ($objection->approved)
                                                                <span class="badge bg-success">Approved</span>
                                                            @else
                                                                <span class="badge bg-warning">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $objection->created_at->format('d M Y') }}</td>
                                                        <td>
                                                            {{-- @if (!$objection->approved)
                                                                <form
                                                                    action="{{ route('admin.objections.approve', $objection->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-success">
                                                                        <i class="fas fa-check"></i> Approve
                                                                    </button>
                                                                </form>
                                                            @endif --}}
                                                            <button class="btn btn-sm btn-info view-details"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#objectionDetailsModal"
                                                                data-title="{{ $objection->title }}"
                                                                data-description="{{ $objection->description }}">
                                                                <i class="fas fa-eye"></i> View
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Teacher Objections Tab -->
                                <div class="tab-pane fade" id="teacher-objections" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Student</th>
                                                    <th>Class</th>
                                                    <th>Branch</th>
                                                    <th>Teacher</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($objections->where('teacher_id', '!=', null) as $objection)
<tr>
                                        <td>{{ $objection->student->name ?? 'N/A' }} ({{ $objection->student->stu_id ?? '' }})</td>
                                        <td>{{ $objection->classLevel->name ?? 'N/A' }}</td>
                                        <td>{{ $objection->branch->branch_name ?? 'N/A' }}</td>
                                        <td>{{ $objection->teacher->name ?? 'N/A' }}</td>
                                        <td>{{ $objection->title }}</td>
                                        <td>{{ Str::limit($objection->description, 50) }}</td>
                                        <td>
                                            @if ($objection->approved)
<span class="badge bg-success">Approved</span>
@else
<span class="badge bg-warning">Pending</span>
@endif
                                        </td>
                                        <td>{{ $objection->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if (!$objection->approved)
<form action="{{ route('admin.objections.approve', $objection->student->stu_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </form>
@endif
                                            <button class="btn btn-sm btn-info view-details" data-bs-toggle="modal"
                                                data-bs-target="#objectionDetailsModal" data-title="{{ $objection->title }}"
                                                data-description="{{ $objection->description }}">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if ($objections instanceof \Illuminate\Pagination\LengthAwarePaginator)
<div class="mt-3">
                    {{ $objections->links() }}
                </div>
@endif
        </div>
    </div>
</div>

                <!-- Pagination -->
                @if ($objections instanceof \Illuminate\Pagination\LengthAwarePaginator)
<div class="mt-3">
                        {{ $objections->links() }}
                    </div>
@endif
            </div>
        </div>
    </div>

    <!-- Add Objection Modal -->
    <div class="modal fade" id="addObjectionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Objection</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.objections.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Branch</label>
                                <select class="form-control branch-select" name="branch_id" id="branchSelect" required>
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
<option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
@endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Class</label>
                                <select class="form-control class-select" name="class_level_id" id="classSelect" required>
                                    <option value="">Select Class</option>
                                    @foreach ($classes as $class)
<option value="{{ $class->id }}">{{ $class->name }}</option>
@endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Student</label>
                                <select class="form-control student-select" name="student_id" id="studentSelect" required>
                                    <option value="">Select Student (Choose branch and class first)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Teacher (Optional)</label>
                                <select class="form-control teacher-select" name="teacher_id" id="teacherSelect">
                                    <option value="">Select Teacher (Optional)</option>
                                    @foreach ($teachers as $teacher)
<option value="{{ $teacher->teacher_id }}">{{ $teacher->name }}</option>
@endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Objection</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="objectionDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detailsModalTitle">Objection Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Description:</h6>
                    <p id="detailsModalDescription"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

                  <script>
                      $(document).ready(function() {
                          // Initialize Select2 for all dropdowns
                          $('.branch-select, .class-select, .teacher-select').select2({
                              theme: 'bootstrap-5'
                          });

                          // Initialize Student Select2 with disabled state
                          var $studentSelect = $('.student-select').select2({
                              theme: 'bootstrap-5',
                              disabled: true,
                              templateResult: formatStudent,
                              templateSelection: formatStudentSelection,
                              escapeMarkup: function(m) {
                                  return m;
                              }
                          });

                          // When branch or class changes, fetch students
                          $('#branchSelect, #classSelect').on('change', function() {
                              var branchId = $('#branchSelect').val();
                              var classId = $('#classSelect').val();

                              if (branchId && classId) {
                                  fetchStudents(branchId, classId);
                              } else {
                                  $studentSelect.val('').trigger('change').prop('disabled', true);
                              }
                          });

                          function fetchStudents(branchId, classId) {
                              $.ajax({
                                  url: "{{ route('admin.getStudentsByBranchClass') }}",
                                  type: "GET",
                                  data: {
                                      branch_id: branchId,
                                      class_level_id: classId
                                  },
                                  success: function(data) {
                                      $studentSelect.empty().append('<option value="">Select Student</option>');

                                      $.each(data.students, function(index, student) {
                                          var option = new Option(
                                              student.name + ' (' + student.stu_id + ')',
                                              student.stu_id,
                                              false,
                                              false
                                          );
                                          // Add image URL to the option data
                                          $(option).data('image', student.image_url ||
                                              '{{ asset('images/default-student.png') }}');
                                          $studentSelect.append(option);
                                      });

                                      $studentSelect.prop('disabled', false);
                                  },
                                  error: function() {
                                      alert('Error loading students');
                                  }
                              });
                          }

                          // Format how student appears in dropdown
                          function formatStudent(student) {
                              if (!student.id) return student.text;

                              var imageUrl = $(student.element).data('image') || '{{ asset('images/default-student.png') }}';
                              var $container = $(
                                  '<div class="d-flex align-items-center">' +
                                  '<img src="' + imageUrl + '" class="rounded-circle me-2" width="30" height="30">' +
                                  '<div>' +
                                  '<div>' + student.text + '</div>' +
                                  '</div>' +
                                  '</div>'
                              );
                              return $container;
                          }

                          // Format how student appears when selected
                          function formatStudentSelection(student) {
                              if (!student.id) return student.text;

                              var imageUrl = $(student.element).data('image') || '{{ asset('images/default-student.png') }}';
                              return $(
                                  '<div class="d-flex align-items-center">' +
                                  '<img src="' + imageUrl + '" class="rounded-circle me-2" width="20" height="20">' +
                                  '<span>' + student.text + '</span>' +
                                  '</div>'
                              );
                          }

                          // View details modal handler
                          $(document).on('click', '.view-details', function() {
                              $('#detailsModalTitle').text($(this).data('title'));
                              $('#detailsModalDescription').text($(this).data('description'));
                          });

                          // When student is selected, auto-fill class and branch
                          $studentSelect.on('change', function() {
                              var studentId = $(this).val();
                              if (studentId) {
                                  $.ajax({
                                      url: "{{ route('admin.getStudentDetails') }}",
                                      type: "GET",
                                      data: {
                                          student_id: studentId
                                      },
                                      success: function(data) {
                                          $('#classSelect').val(data.class_level_id).trigger('change');
                                          $('#branchSelect').val(data.branch_id).trigger('change');
                                      }
                                  });
                              }
                          });
                      });
                  </script>
@endpush

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
                    rel="stylesheet" />

                <style>
                    .table-hover tbody tr:hover {
                        background-color: rgba(0, 0, 0, 0.05);
                    }

                    .badge {
                        font-size: 0.85em;
                        padding: 0.35em 0.65em;
                    }

                    .select2-container--bootstrap-5 .select2-dropdown .select2-results__option {
                        padding: 0.5rem 1rem;
                    }

                    .select2-container--bootstrap-5 .select2-dropdown .select2-results__option--highlighted {
                        background-color: #f8f9fa;
                        color: #000;
                    }

                    .select2-selection__rendered {
                        line-height: 36px !important;
                    }

                    .select2-container .select2-selection--single {
                        height: 38px !important;
                    }

                    .select2-container--disabled .select2-selection {
                        background-color: #f8f9fa;
                        cursor: not-allowed;
                    }

                    .select2-container--bootstrap-5 .select2-results__option {
                        padding: 8px 12px;
                    }

                    .select2-container--bootstrap-5 .select2-selection--single {
                        height: auto !important;
                        min-height: 38px;
                        padding: 4px;
                    }

                    .select2-container--bootstrap-5 .select2-results__option img {
                        width: 30px;
                        height: 30px;
                        object-fit: cover;
                        margin-right: 10px;
                        border-radius: 50%;
                    }

                    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered img {
                        width: 20px;
                        height: 20px;
                        margin-right: 8px;
                        border-radius: 50%;
                    }

                    .select2-container--bootstrap-5 .select2-dropdown .select2-results__option {
                        padding: 8px 12px;
                        display: flex;
                        align-items: center;
                    }

                    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
                        display: flex;
                        align-items: center;
                    }
                </style>
@endpush)
