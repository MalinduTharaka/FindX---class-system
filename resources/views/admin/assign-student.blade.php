@extends('layouts.app')

@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Okay'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'Okay'
            });
        </script>
    @endif

    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        {{-- <div class="col-12">
                                 <div class="avatar bg-primary rounded">
                                      <i class="bx bx-layer avatar-title fs-24 text-white"></i>
                                 </div>
                            </div> <!-- end col --> --}}
                        <div class="col-12 text-center">
                            <p class="text-muted mb-0 text-truncate fs-5">Class Name</p>
                            <h3 class="text-dark mt-1 mb-0 fs-2">{{ $class->name }}</h3>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-md bg-success rounded">
                                <i class="bx bx-award avatar-title fs-24 text-white"></i>
                            </div>
                        </div> <!-- end col -->
                        <div class="col-6 text-end">
                            <p class="text-muted mb-0 text-truncate">Teacher</p>
                            <h3 class="text-dark mt-1 mb-0">{{ $class->teacher }}</h3>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-md bg-danger rounded">
                                <i class="bx bxs-backpack avatar-title fs-24 text-white"></i>
                            </div>
                        </div> <!-- end col -->
                        <div class="col-6 text-end">
                            <p class="text-muted mb-0 text-truncate">Grade</p>
                            <h3 class="text-dark mt-1 mb-0">{{ $class->grade->name }}</h3>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-md text-bg-warning rounded">
                                <i class="bx bx-dollar-circle avatar-title fs-24"></i>
                            </div>
                        </div> <!-- end col -->
                        <div class="col-6 text-end">
                            <p class="text-muted mb-0 text-truncate">Subject</p>
                            <h3 class="text-dark mt-1 mb-0">{{ $class->subject->name }}</h3>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="hstack gap-2">
        <button class="btn btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
            aria-expanded="false" aria-controls="collapseExample">
            Assign Student
        </button>
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal"
            id="add-btn">
            Add Student and Assign
        </button>
        <button class="btn btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#attendeceModel"
            aria-expanded="false" aria-controls="attendeceModel">
            Attendance
        </button>
        <button class="btn btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#attendecePayModel"
            aria-expanded="false" aria-controls="attendecePayModel">
            Attendance And Pay
        </button>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="collapse" id="collapseExample">
        <div class="card mb-0">
            <div class="card-body">
                <form id="assignStudentForm">
                    @csrf
                    <div class="mb-3">
                        <select class="form-control" data-choices name="student_id" id="student_id">
                            <option value="">Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->id }} - {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <input type="hidden" name="class_id" id="class_id" value="{{ $class->id }}">
                    
                    <div class="mb-3">
                        <label for="added_year" class="form-label">Added Year</label>
                        <input type="text" id="added_year" class="form-control" name="added_year">
                    </div>
                
                    <input type="hidden" name="new_old_status" id="new_old_status" value="{{ $class->new_old_status }}">
                
                    <button type="submit" class="btn btn-success">Assign</button>
                </form>
                
            </div>
        </div>
    </div>

    
    

    {{-- Create student and assign model --}}

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Student Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="assignCreateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="">
                            <div>
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Student Name</label>
                                    <input type="text" id="simpleinput" class="form-control" name="name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Address</label>
                                    <input type="text" id="simpleinput" class="form-control" name="address">
                                </div>

                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Parent Name</label>
                                    <input type="text" id="simpleinput" class="form-control" name="parent_name">
                                </div>

                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Parent Contact number</label>
                                    <input type="number" id="simpleinput" class="form-control" name="parent_contact">
                                </div>

                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Student Contact number</label>
                                    <input type="number" id="simpleinput" class="form-control" name="student_contact"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Whatsapp number</label>
                                    <input type="number" id="simpleinput" class="form-control" name="whatsapp_num">
                                </div>

                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">School Name</label>
                                    <input type="text" id="simpleinput" class="form-control" name="school_name">
                                </div>

                                <div class="dropdown mb-3">
                                    <label for="simpleinput" class="form-label">Gender</label><br>
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Male
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#" id="male"
                                            data-value="Male">Male</a>
                                        <a class="dropdown-item" href="#" id="female"
                                            data-value="Female">Female</a>
                                    </div>

                                    <!-- Hidden input field to store the selected value -->
                                    <input type="hidden" id="gender" value="Male" name="gender">
                                </div>

                                {{-- Gender show scripts --}}
                                <script>
                                    // Set the default selected value as "Male"
                                    document.getElementById('male').addEventListener('click', function() {
                                        document.getElementById('dropdownMenuButton1').textContent = 'Male';
                                        document.getElementById('gender').value = 'Male'; // Update the hidden input value
                                    });

                                    // When "Female" is clicked, update the button text and hidden input value
                                    document.getElementById('female').addEventListener('click', function() {
                                        document.getElementById('dropdownMenuButton1').textContent = 'Female';
                                        document.getElementById('gender').value = 'Female'; // Update the hidden input value
                                    });
                                </script>

                                <script>
                                    // For example, to access the value when needed
                                    console.log(document.getElementById('gender').value);
                                </script>
                                {{-- Gender show scripts end --}}


                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Birthday</label>
                                    <input type="text" id="basic-datepicker" class="form-control"
                                        placeholder="Birthday" name="dob">
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            flatpickr("#basic-datepicker", {
                                                dateFormat: "Y-m-d", // Optional: specify the date format if needed
                                            });
                                        });
                                    </script>
                                </div>


                                <div class="mb-3">
                                    <input type="text" id="simpleinput" class="form-control" name="class_id" hidden
                                        value="{{ $class->id }}">
                                </div>

                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Added Year</label>
                                    <input type="text" id="simpleinputyearnew" class="form-control"
                                        name="added_year">

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            document.getElementById("simpleinputyearnew").value = new Date().getFullYear();
                                        });
                                    </script>

                                </div>

                                <div class="mb-3">
                                    <input type="text" id="simpleinput" class="form-control" name="new_old_status"
                                        hidden value="{{ $class->new_old_status }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Proceed</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- Attendance model --}}
    <div class="collapse" id="attendeceModel">
        <div class="card mb-0">
            <div class="card-body">
                <form method="POST" action="/attendances/store">
                    @csrf
                    <div class="mb-3">
                        <select class="form-control" id="studentSelect" data-choices name="student_id">
                            <option value="">You can search by student name / id</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->id }} - {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Table is initially hidden -->
<!-- Table is initially hidden -->
<table class="table table-centered" id="attendanceTableContainer" style="display: none;">
    <thead class="table-dark">
        <tr>
            <th scope="col">Student</th>
            <th scope="col">Date</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody id="attendanceTable">
        @foreach ($attendances as $attendance)
            <tr data-student-id="{{ $attendance->student_id }}"
                data-class-id="{{ $attendance->class_id }}"
                data-created-at="{{ $attendance->created_at }}">
                <td>{{ $attendance->student->name }}</td>
                <td>{{ $attendance->attendance_date }}</td>
                <td>{{ $attendance->status }}</td>
            </tr>
        @endforeach
    </tbody>
    
</table>




                    <div class="mb-3">
                        <input type="text" id="simpleinput" class="form-control" name="class_id" hidden
                            value="{{ $class->id }}">
                    </div>

                    <button type="submit" class="btn btn-success">Attended</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Attendance and pay model --}}
    <div class="collapse" id="attendecePayModel">
        <div class="card mb-0">
            <div class="card-body">
                <form id="attendPayForm">
                    @csrf
                    <div class="mb-3">
                        <select class="form-control" id="studentSelect1" data-choices name="student_id">
                            <option value="">You can search by student name / id</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->id }} - {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="">Class Fee</label>
                        <input type="text" id="simpleinput" class="form-control" name="total" readonly
                            value="{{ $class->class_fee }}">
                    </div>

                    <div class="mb-3">
                        <label for="">Pay Amount</label>
                        <input type="text" id="simpleinput" class="form-control" name="paid_amount">
                    </div>

                    <div class="mb-3">
                        <label for="">Payment Month</label>
                        <select class="form-control" name="month">
                            <option value="0" selected>Attend only</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>

                    <div class="row">
                        <!-- First Table Column -->
                        <div class="col-md-6">
                            <table class="table table-centered" id="attendanceTableContainer1" style="display: none;">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Student</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="attendanceTable1">
                                    @foreach ($attendances as $attendance)
                                        <tr data-student-id="{{ $attendance->student_id }}"
                                            data-class-id="{{ $attendance->class_id }}">
                                            <td>{{ $attendance->student->name }}</td>
                                            <td>{{ $attendance->attendance_date }}</td>
                                            <td>{{ $attendance->status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    
                        <!-- Second Table Column -->
                        <div class="col-md-6">
                            <table class="table table-centered" id="attendanceAndPayTableContainer" style="display: none;">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Student</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Paid Amount</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody id="attendanceAndPayTable">
                                    @foreach ($payments as $payment)
                                        <tr data-student-id="{{ $payment->student_id }}"
                                            data-class-id="{{ $payment->class_id }}">
                                            <td>{{ $payment->student->name }}</td>
                                            <td>{{ $payment->total }}</td>
                                            <td>{{ $payment->paid_amount }}</td>
                                            <td>{{ $payment->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    

                    <div class="mb-3">
                        <input type="text" id="simpleinput" class="form-control" name="class_id" hidden
                            value="{{ $class->id }}">
                    </div>

                    <button type="submit" class="btn btn-success">Done</button>
                </form>
            </div>
        </div>
    </div>



    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-1 anchor" id="basic">
                    Assign Student Details
                </h5>
                <button class="btn btn-success"
                    onclick="event.preventDefault(); document.getElementById('upgrade-form').submit();">
                    Upgrade<i class="bi bi-arrow-up"></i>
                </button>
                <form id="upgrade-form" method="POST" action="{{ route('assign-student.upgrade', $class->id) }}"
                    style="display: none;">
                    @csrf
                </form>

            </div>
            <div class="table-responsive">
                <table class="table table-centered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Student Name</th>
                            <th scope="col">Class Name</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Year</th>
                            <th scope="col">Added Date & Time</th>
                            <th scope="col">New / Old</th>
                            <th scope="col">Assign Status</th>
                            <th scope="col">Deactive Date</th>
                            <th scope="col">Deactive Reason</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assigns as $assign)
                            <tr class="{{ $assign->status == 'inactive' ? 'opacity-50' : '' }}">
                                <td>{{ $assign->student->name }}</td>
                                <td>{{ $assign->class->name }}</td>
                                <td>{{ $assign->class->grade->name }}</td>
                                <td>{{ $assign->added_year }}</td>
                                <td>{{ $assign->added_datetime }}</td>
                                <td>{{ $assign->new_old_status == 'new' ? 'new' : '' }}</td>
                                <td class="{{ $assign->status == 'active' ? 'table-success' : 'table-danger' }}">
                                    {{ $assign->status }}
                                </td>
                                <td>{{ $assign->deactivate_date }}</td>
                                <td>{{ $assign->deactivate_reason }}</td>
                                <td>
                                    <button class="btn btn-outline-info" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" data-id="{{ $assign->id }}"
                                        data-added-year="{{ $assign->added_year }}" data-status="{{ $assign->status }}"
                                        data-deactivate-date="{{ $assign->deactivate_date }}"
                                        data-deactivate-reason="{{ $assign->deactivate_reason }}"
                                        data-new-old-status="{{ $assign->new_old_status }}" onclick="populateForm(this)">
                                        Edit
                                    </button>

                                    {{-- Update Form --}}
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <form method="POST" id="updateForm"
                                                        action="/assign-student/update/{{ $assign->id }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="added_year" class="form-label">Added Year</label>
                                                            <select id="added_year" class="form-control"
                                                                name="added_year">
                                                                <!-- Options will be dynamically added here -->
                                                            </select>
                                                        </div>


                                                        <div class="mb-3">
                                                            <label for="classname" class="form-label">New /
                                                                Old</label><br>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="new_old_status" id="newcheck" value="new">
                                                                <label class="form-check-label" for="new">New</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="new_old_status" id="oldcheck" value="old">
                                                                <label class="form-check-label" for="old">Old</label>
                                                            </div>
                                                        </div>

                                                        <button type="submit" class="btn btn-success">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalDelete">
                                        Delete</button>
                                </td>

                                {{-- Delete Form --}}
                                <div class="modal fade" id="exampleModalDelete" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form method="POST" id="deleteForm"
                                                    action="/assign/deactivate/{{ $assign->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3" id="deactivateFields1">
                                                        <label for="simpleinput" class="form-label">Deactivate
                                                            Reason</label>
                                                        <input type="text" id="deactivate_reason" class="form-control"
                                                            name="deactivate_reason" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function populateForm(button) {
            // Get the data from the button's data attributes
            const Id = button.getAttribute('data-id');
            const addedYear = button.getAttribute('data-added-year');
            const status = button.getAttribute('data-status');
            const deactivateDate = button.getAttribute('data-deactivate-date');
            const deactivateReason = button.getAttribute('data-deactivate-reason');
            const newOldStatus = button.getAttribute('data-new-old-status');

            // Fill in the form fields
            document.getElementById('added_year').value = addedYear;

            if (status === 'active') {
                document.getElementById('status_active').checked = true;
                document.getElementById('status_inactive').checked = false;
            } else {
                document.getElementById('status_active').checked = false;
                document.getElementById('status_inactive').checked = true;
            }

            if (status === 'inactive') {
                document.getElementById('deactivateFields').style.display = 'block';
                document.getElementById('deactivate_date').value = deactivateDate;
                document.getElementById('deactivate_reason').value = deactivateReason;
            } else {
                document.getElementById('deactivateFields').style.display = 'none';
            }

            if (newOldStatus === 'new') {
                document.getElementById('newcheck').checked = true;
            } else if (newOldStatus === 'old') {
                document.getElementById('oldcheck').checked = true;
            }
        }

        function toggleFields() {
            const status = document.querySelector('input[name="status"]:checked').value;
            const deactivateFields = document.getElementById('deactivateFields');

            if (status === 'inactive') {
                deactivateFields.style.display = 'block';
            } else {
                deactivateFields.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const addedYearSelect = document.getElementById('added_year');
            const currentYear = new Date().getFullYear();
            const startYear = 2000;

            // Populate the select options
            for (let year = startYear; year <= currentYear; year++) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                addedYearSelect.appendChild(option);
            }
        });
    </script>

    <script>
        document.getElementById('studentSelect').addEventListener('change', function () {
            let selectedStudentId = this.value;
            let tableContainer = document.getElementById('attendanceTableContainer');
            let rows = Array.from(document.querySelectorAll('#attendanceTable tr'));
            let classId = "{{ $class->id }}"; // Get the class ID from Blade

            if (selectedStudentId === "") {
                tableContainer.style.display = "none"; // Hide table if no student is selected
                return;
            } else {
                tableContainer.style.display = "table"; // Show table when a student is selected
            }

            // Filter rows based on student and class ID
            let filteredRows = rows.filter(row =>
                row.getAttribute('data-student-id') === selectedStudentId &&
                row.getAttribute('data-class-id') === classId
            );

            // Sort filtered rows by 'created_at' timestamp (assuming it's stored in a data attribute)
            filteredRows.sort((a, b) => {
                let dateA = new Date(a.getAttribute('data-created-at'));
                let dateB = new Date(b.getAttribute('data-created-at'));
                return dateB - dateA; // Sort in descending order (newest first)
            });

            // Show only the latest 4 rows
            rows.forEach(row => row.style.display = "none"); // Hide all rows first
            filteredRows.slice(0, 4).forEach(row => row.style.display = ""); // Show top 4 rows
        });


        document.getElementById('studentSelect1').addEventListener('change', function() {
            let selectedStudentId = this.value;
            let tableContainer = document.getElementById('attendanceTableContainer1');
            let rows = document.querySelectorAll('#attendanceTable1 tr');
            let classId = "{{ $class->id }}"; // Get the class ID from Blade

            if (selectedStudentId === "") {
                tableContainer.style.display = "none"; // Hide table if no student is selected
            } else {
                tableContainer.style.display = "table"; // Show table when a student is selected
            }

            rows.forEach(row => {
                if (
                    row.getAttribute('data-student-id') === selectedStudentId &&
                    row.getAttribute('data-class-id') === classId
                ) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        document.getElementById('studentSelect1').addEventListener('change', function() {
            let selectedStudentId = this.value;
            let tableContainer = document.getElementById('attendanceAndPayTableContainer');
            let rows = document.querySelectorAll('#attendanceAndPayTable tr');
            let classId = "{{ $class->id }}"; // Get the class ID from Blade

            if (selectedStudentId === "") {
                tableContainer.style.display = "none"; // Hide table if no student is selected
            } else {
                tableContainer.style.display = "table"; // Show table when a student is selected
            }

            rows.forEach(row => {
                if (
                    row.getAttribute('data-student-id') === selectedStudentId &&
                    row.getAttribute('data-class-id') === classId
                ) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $('#assignStudentForm').submit(function(event) {
            event.preventDefault(); // Prevent form from refreshing the page

            let formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: "/assign-student/store", // Laravel Route
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        });

                        // Optionally, refresh part of the page dynamically
                        location.reload();
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error!",
                        text: xhr.responseJSON.message || "Something went wrong.",
                        icon: "error"
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        $('#assignCreateForm').submit(function(event) {
            event.preventDefault(); // Prevent form from refreshing the page

            let formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: "/assign/create", // Laravel Route
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        });

                        // Optionally, refresh part of the page dynamically
                        location.reload();
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error!",
                        text: xhr.responseJSON.message || "Something went wrong.",
                        icon: "error"
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        $('#attendPayForm').submit(function(event) {
            event.preventDefault(); // Prevent form from refreshing the page

            let formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: "/pay-class-fee", // Laravel Route
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error!",
                        text: xhr.responseJSON.message || "Something went wrong.",
                        icon: "error"
                    });
                }
            });
        });
    });

    function fetchUpdatedTables(studentId) {
    $.ajax({
        url: `/get-student-data/${studentId}`, // Laravel route to fetch updated data
        type: "GET",
        success: function (response) {
            if (response.success) {
                let attendanceTable = $("#attendanceTable1");
                let paymentTable = $("#attendanceAndPayTable");

                // Clear previous table content
                attendanceTable.empty();
                paymentTable.empty();

                // Populate updated attendance data (limit to 2 newest)
                response.attendances.slice(0, 2).forEach(attendance => {
                    attendanceTable.append(`
                        <tr>
                            <td>${attendance.student.name}</td>
                            <td>${attendance.attendance_date}</td>
                            <td>${attendance.status}</td>
                        </tr>
                    `);
                });

                // Populate updated payment data (limit to 2 newest)
                response.payments.slice(0, 2).forEach(payment => {
                    paymentTable.append(`
                        <tr>
                            <td>${payment.student.name}</td>
                            <td>${payment.total}</td>
                            <td>${payment.paid_amount}</td>
                            <td>${payment.created_at}</td>
                        </tr>
                    `);
                });

                // Show tables if there is data
                $("#attendanceTableContainer1").toggle(response.attendances.length > 0);
                $("#attendanceAndPayTableContainer").toggle(response.payments.length > 0);
            }
        }
    });
}

// Handle student selection to filter tables
$('#studentSelect1').change(function () {
    let selectedStudentId = $(this).val();
    fetchUpdatedTables(selectedStudentId);
});

</script>
@endsection
