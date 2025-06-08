@extends('layouts.app')

@section('content')
    <div class="hstack gap-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="add-btn">Add
            Student</button>
    </div>

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



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Student Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/student/create">
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
                                    <input type="number" id="simpleinput" class="form-control" name="student_contact" required>
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
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Male
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#" id="male" data-value="Male">Male</a>
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
                                    <input type="text" id="basic-datepicker" class="form-control"
                                        placeholder="Basic datepicker" name="dob">
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            flatpickr("#basic-datepicker", {
                                                dateFormat: "Y-m-d", // Optional: specify the date format if needed
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1 anchor" id="tablehead">
                        Students
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-centered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Parent Name</th>
                                    <th scope="col">Parent contact Number</th>
                                    <th scope="col">Student Contact Number</th>
                                    <th scope="col">Whatsapp Number</th>
                                    <th scope="col">School Name</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Date of Birth</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->address }}</td>
                                        <td>{{ $student->parent_name }}</td>
                                        <td>{{ $student->parent_contact }}</td>
                                        <td>{{ $student->student_contact }}</td>
                                        <td>{{ $student->whatsapp_num }}</td>
                                        <td>{{ $student->school_name }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>{{ $student->dob }}</td>
                                        <td>
                                            <button class="btn btn-outline-info edit-btn" data-id="{{ $student->id }}"
                                                data-name="{{ $student->name }}" data-address="{{ $student->address }}"
                                                data-parent_name="{{ $student->parent_name }}"
                                                data-parent_contact="{{ $student->parent_contact }}"
                                                data-student_contact="{{ $student->student_contact }}"
                                                data-whatsapp_num="{{ $student->whatsapp_num }}"
                                                data-school_name="{{ $student->school_name }}"
                                                data-gender="{{ $student->gender }}" data-dob="{{ $student->dob }}"
                                                data-bs-toggle="modal" data-bs-target="#updateStudentModal">Edit</button>


                                            <form action="/student/delete/{{ $student->id }}" method="POST"
                                                id="deleteForm{{ $student->id }}" style="display:none;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" id="deleteBtn{{ $student->id }}"></button>
                                            </form>

                                            <button class="btn btn-outline-warning"
                                                onclick="confirmDelete({{ $student->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end card body -->
        </div>
    </div>

    <!-- Update Student Modal -->
    <div class="modal fade" id="updateStudentModal" tabindex="-1" aria-labelledby="updateStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStudentModalLabel">Update Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" id="updateForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Input Fields -->
                        <div class="mb-3">
                            <label for="update-name" class="form-label">Student Name</label>
                            <input type="text" id="update-name" class="form-control" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="update-address" class="form-label">Address</label>
                            <input type="text" id="update-address" class="form-control" name="address">
                        </div>

                        <div class="mb-3">
                            <label for="update-parent-name" class="form-label">Parent Name</label>
                            <input type="text" id="update-parent-name" class="form-control" name="parent_name">
                        </div>

                        <div class="mb-3">
                            <label for="update-parent-contact" class="form-label">Parent Contact Number</label>
                            <input type="number" id="update-parent-contact" class="form-control" name="parent_contact">
                        </div>

                        <div class="mb-3">
                            <label for="update-student-contact" class="form-label">Student Contact Number</label>
                            <input type="number" id="update-student-contact" class="form-control"
                                name="student_contact">
                        </div>

                        <div class="mb-3">
                            <label for="update-whatsapp-num" class="form-label">Whatsapp Number</label>
                            <input type="number" id="update-whatsapp-num" class="form-control" name="whatsapp_num">
                        </div>

                        <div class="mb-3">
                            <label for="update-school-name" class="form-label">School Name</label>
                            <input type="text" id="update-school-name" class="form-control" name="school_name">
                        </div>

                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="updateGenderDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Male
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" id="update-male" data-value="Male">Male</a>
                                <a class="dropdown-item" href="#" id="update-female"
                                    data-value="Female">Female</a>
                            </div>
                            <input type="hidden" id="update-gender" name="gender" value="Male">
                        </div>

                        <div class="mb-3">
                            <input type="text" id="update-dob" class="form-control" placeholder="Date of Birth"
                                name="dob">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Handle "Edit" button click
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {

                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const address = this.getAttribute('data-address');
                    const parentName = this.getAttribute('data-parent_name');
                    const parentContact = this.getAttribute('data-parent_contact');
                    const studentContact = this.getAttribute('data-student_contact');
                    const whatsappNum = this.getAttribute('data-whatsapp_num');
                    const schoolName = this.getAttribute('data-school_name');
                    const gender = this.getAttribute('data-gender');
                    const dob = this.getAttribute('data-dob');

                    // Populate update modal fields
                    document.getElementById('update-name').value = name;
                    document.getElementById('update-address').value = address;
                    document.getElementById('update-parent-name').value = parentName;
                    document.getElementById('update-parent-contact').value = parentContact;
                    document.getElementById('update-student-contact').value = studentContact;
                    document.getElementById('update-whatsapp-num').value = whatsappNum;
                    document.getElementById('update-school-name').value = schoolName;
                    document.getElementById('updateGenderDropdown').textContent = gender;
                    document.getElementById('update-gender').value = gender;
                    document.getElementById('update-dob').value = dob;

                    // Update form action for the specific student
                    const updateForm = document.getElementById('updateForm');
                    updateForm.action = `/student/update/${id}`;
                });
            });

            // Gender dropdown update logic for update modal
            document.getElementById('update-male').addEventListener('click', function() {
                document.getElementById('updateGenderDropdown').textContent = 'Male';
                document.getElementById('update-gender').value = 'Male';
            });

            document.getElementById('update-female').addEventListener('click', function() {
                document.getElementById('updateGenderDropdown').textContent = 'Female';
                document.getElementById('update-gender').value = 'Female';
            });

            // Initialize datepicker for the update modal
            flatpickr("#update-dob", {
                dateFormat: "Y-m-d",
            });
        });

        function confirmDelete(studentId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + studentId).submit();
                }
            });
        }
    </script>
@endsection
