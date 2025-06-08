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
    <!--Add Class Modal -->
    <div class="modal fade" id="subject-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/classes/store">
                    @csrf
                    <div class="modal-body">

                        <div class="form-check form-switch mb-5">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="new_old_status" value="new">
                            <label class="form-check-label" for="flexSwitchCheckDefault">On to create new class<br>( If have 2 classes with same grade in same year ) </label>
                        </div>

                        <div class="mb-3">
                            <label for="simpleinput" class="form-label">Class Name</label>
                            <input type="text" id="simpleinput" class="form-control" name="name">
                        </div>

                        <div class="dropdown mb-3">
                            <button id="gradeButton" type="button" class="btn btn-info dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Grade
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($grades as $grade)
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="setGrade('{{ $grade->id }}', '{{ $grade->name }}')">{{ $grade->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <input type="hidden" id="grade_id" name="grade_id">
                        </div>

                        <div class="dropdown mb-3">
                            <button id="subjectButton" type="button" class="btn btn-info dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Subject
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($subjects as $subject)
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="setSubject('{{ $subject->id }}', '{{ $subject->name }}')">{{ $subject->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <input type="hidden" id="subject_id" name="subject_id">
                        </div>


                        <script>
                            function setGrade(id, name) {
                                document.getElementById('gradeButton').textContent = name;
                                document.getElementById('grade_id').value = id;
                            }

                            function setSubject(id, name) {
                                document.getElementById('subjectButton').textContent = name;
                                document.getElementById('subject_id').value = id;
                            }
                        </script>


                        <div class="mb-3">
                            <label for="simpleinput" class="form-label">Teacher name</label>
                            <input type="text" id="simpleinput" class="form-control" name="teacher">
                        </div>

                        <div class="mb-3">
                            <label for="simpleinput" class="form-label">Class Fee (Rs)</label>
                            <input type="number" id="simpleinput" class="form-control" name="class_fee">
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


    {{-- Update Class Model --}}

    <div class="modal fade" id="class-update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" id="updateClassForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="classname" class="form-label">New / Old </label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="new_old_status" id="inlineRadio1" value="new">
                                <label class="form-check-label" for="inlineRadio1">New</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="new_old_status" id="inlineRadio2" value="old">
                                <label class="form-check-label" for="inlineRadio2">Old</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="classname" class="form-label">Class Name</label>
                            <input type="text" id="classname" class="form-control" name="name">
                        </div>

                        <div class="dropdown mb-3">
                            <button id="gradeButton1" type="button" class="btn btn-info dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Grade
                            </button>
                            <ul class="dropdown-menu" id="gradeDropdown1">
                                @foreach ($grades as $grade)
                                    <li>
                                        <a class="dropdown-item" href="#" data-id="{{ $grade->id }}">
                                            {{ $grade->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <input type="hidden" id="grade_id1" name="grade_id">
                        </div>

                        <div class="dropdown mb-3">
                            <button id="subjectButton1" type="button" class="btn btn-info dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Subject
                            </button>
                            <ul class="dropdown-menu" id="subjectDropdown1">
                                @foreach ($subjects as $subject)
                                    <li>
                                        <a class="dropdown-item"
                                        data-id="{{ $subject->id }}">{{ $subject->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <input type="hidden" id="subject_id1" name="subject_id">
                        </div>


                        <div class="mb-3">
                            <label for="teacher" class="form-label">Teacher Name</label>
                            <input type="text" id="teacher" class="form-control" name="teacher">
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

    <!-- Fee Modal -->
<div class="modal fade" id="updateFeeModal" tabindex="-1" aria-labelledby="updateFeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateFeeModalLabel">Update Class Fee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="feeUpdateForm">
                    <div class="mb-3">
                        <label for="new_fee" class="form-label">New Class Fee</label>
                        <input type="number" class="form-control" id="new_fee" name="new_fee" required>
                    </div>
                    <input type="hidden" id="class_id" name="class_id">
                    <input type="hidden" id="old_fee" name="old_fee">
                    <button type="submit" class="btn btn-primary">Update Fee</button>
                </form>
            </div>
        </div>
    </div>
</div>



    <div class="card">
        <div class="card-body">
            <button type="button" class="btn btn-soft-info mb-3" data-bs-toggle="modal" data-bs-target="#subject-add">
                Add Class
            </button>
            <h5 class="card-title mb-1 anchor" id="tablehead">
                Class
            </h5>

            <div class="table-responsive">
                <table class="table table-centered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Class Name</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Teacher</th>
                            <th scope="col">New/Old</th>
                            <th scope="col">Class Fee</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $class)
                            <tr>
                                <td>{{ $class->name }}</td>
                                <td>{{ $class->grade ? $class->grade->name : 'N/A' }}</td>
                                <td>{{ $class->subject ? $class->subject->name : 'N/A' }}</td>
                                <td>{{ $class->teacher }}</td>
                                <td>{{ $class->new_old_status}}</td>
                                <td>
                                    {{ $class->class_fee }}
                                    @if(!empty($class->class_fee))
                                        <button id="fee-update" class="btn btn-outline-info" data-id="{{ $class->id }}" data-fee="{{ $class->class_fee }}">Update</button>
                                    @endif
                                </td>
                                
                                
                                <td>
                                    <a href="{{ route('assign-student', ['id' => $class->id]) }}" class="btn btn-success">Assign Students</a>
                                    <button class="btn btn-outline-info" data-bs-toggle="modal"
                                        data-bs-target="#class-update"
                                        onclick="populateModal('{{ $class->id }}', '{{ $class->name }}', '{{ $class->grade_id }}', '{{ $class->subject_id }}', '{{ $class->teacher }}', '{{ $class->new_old_status}}')">
                                        Edit
                                    </button>
                                    <form action="/classes/delete/{{ $class->id }}" method="POST"
                                        id="deleteForm{{ $class->id }}" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn btn-outline-warning" onclick="confirmDelete('{{ $class->id }}')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
        function populateModal(classId, className, gradeId, subjectId, teacherName, new_old_status) {
            const form = document.getElementById('updateClassForm');
            form.action = `/classes/update/${classId}`;

            // Set class name
            document.getElementById('classname').value = className;

            // Set grade and update dropdown button text
            @foreach ($grades as $grade)
                if ('{{ $grade->id }}' === gradeId) {
                    setGrade('{{ $grade->id }}', '{{ $grade->name }}');
                }
            @endforeach

            // Set subject and update dropdown button text
            @foreach ($subjects as $subject)
                if ('{{ $subject->id }}' === subjectId) {
                    setSubject('{{ $subject->id }}', '{{ $subject->name }}');
                }
            @endforeach

            // Set teacher name
            document.getElementById('teacher').value = teacherName;

            // Get the select element and the first option
            // Select the appropriate radio button for new_old_status
            const newRadio = document.getElementById('inlineRadio1');
            const oldRadio = document.getElementById('inlineRadio2');
            if (new_old_status === 'new') {
                newRadio.checked = true;
            } else if (new_old_status === 'old') {
                oldRadio.checked = true;
            }

            // Ensure that grade and subject can be updated after modal opens
            function setGrade(id, name) {
                document.getElementById('gradeButton1').textContent = name; // Update button text
                document.getElementById('grade_id1').value = id; // Update hidden input value
            }

            function setSubject(id, name) {
                document.getElementById('subjectButton1').textContent = name; // Update button text
                document.getElementById('subject_id1').value = id; // Update hidden input value
            }

            // When selecting a new grade
            const gradeItems = document.querySelectorAll('#gradeDropdown1 .dropdown-item');
            gradeItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    const gradeId = e.target.getAttribute('data-id');
                    const gradeName = e.target.textContent;
                    setGrade(gradeId, gradeName);
                });
            });

            // When selecting a new subject
            const subjectItems = document.querySelectorAll('#subjectDropdown1 .dropdown-item');
                subjectItems.forEach(item => {
                    item.addEventListener('click', function (e) {
                        const subjectId = e.target.getAttribute('data-id');
                        const subjectName = e.target.textContent;
                        setSubject(subjectId, subjectName);
                    });
            });
        }


        function confirmDelete(classId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with form submission if confirmed
                    document.getElementById('deleteForm' + classId).submit();
                }
            });
        }


</script>

<script>
    document.querySelectorAll('#fee-update').forEach(button => {
    button.addEventListener('click', function() {
        const classId = this.getAttribute('data-id');
        const oldFee = this.getAttribute('data-fee');
        
        // Set the old fee and class id in the modal form
        document.getElementById('class_id').value = classId;
        document.getElementById('old_fee').value = oldFee;
        document.getElementById('new_fee').value = oldFee; // Optionally pre-fill with old fee

        // Show the modal
        new bootstrap.Modal(document.getElementById('updateFeeModal')).show();
    });
});

document.getElementById('feeUpdateForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const classId = document.getElementById('class_id').value;
    const oldFee = document.getElementById('old_fee').value;
    const newFee = document.getElementById('new_fee').value;

    // Send data to the backend
    fetch(`/update-class-fee/${classId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ old_fee: oldFee, new_fee: newFee })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: 'Class fee updated successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload(); // Reload page to see updated fee
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'There was an error updating the class fee.',
                icon: 'error',
                confirmButtonText: 'Try Again'
            });
        }
    });
});

</script>
@endsection
