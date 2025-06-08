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


<div class="row mt-3">
    <div class="col-xl-7">

        <!--Add Subject Modal -->
        <div class="modal fade" id="subject-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/grade-subject/createSubject">
                        @csrf
                        <div class="modal-body">
                                
                                <div class="mb-3">
                                    <label for="simpleinput" class="form-label">Subject</label>
                                    <input type="text" id="simpleinput" class="form-control" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Note</label>
                                <input type="text" id="simpleinput" class="form-control" name="note">
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

        {{-- Edit Subject Modal --}}
        <div class="modal fade" id="subject-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateSubjectForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                                
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Subject</label>
                                <input type="text" id="SubjectName" class="form-control" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Note</label>
                                <input type="text" id="SubjectNote" class="form-control" name="note">
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-soft-info mb-3" data-bs-toggle="modal" data-bs-target="#subject-add">
                    Add Subject
                </button>
                <h5 class="card-title mb-1 anchor" id="tablehead">
                    Subjects
                </h5>
                <div class="table-responsive">
                    <table class="table table-centered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Note</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->note }}</td>
                                    <td>
                                        <button class="btn btn-outline-info edit-subject-btn"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#subject-edit" 
                                            data-id="{{ $subject->id }}" 
                                            data-name="{{ $subject->name }}"
                                            data-note="{{ $subject->note }}">
                                            Edit
                                        </button>

                                        <form action="/grade-subject/deleteSubject/{{ $subject->id }}" method="POST" id="deleteFormSubject{{ $subject->id }}" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <button class="btn btn-outline-warning" onclick="confirmDeleteSubject({{ $subject->id }})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end card body -->
    </div>

    <div class="col-xl-5">
        <!-- Add Grade Modal -->
        <div class="modal fade" id="grade-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Grade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/grade-subject/createGrade">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Grade</label>
                                <input type="text" id="simpleinput" class="form-control" name="name">
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

        <!-- Update Grade Modal -->

        <div class="modal fade" id="grade-update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Grade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateGradeForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Grade</label>
                                <input type="text" id="grade-name" class="form-control" name="name" value="">
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

        <div class="card">
            <div class="card-body">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-soft-info mb-3" data-bs-toggle="modal" data-bs-target="#grade-add">
                    Add Grade
                </button>
                <h5 class="card-title mb-1 anchor" id="tablehead">
                    Grades
                </h5>
                <div class="table-responsive">
                    <table class="table table-centered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Name</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grades as $grade)
                                <tr>
                                    <td>{{ $grade->name }}</td>
                                    <td>
                                        <button 
                                            class="btn btn-outline-info edit-grade-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#grade-update" 
                                            data-id="{{ $grade->id }}" 
                                            data-name="{{ $grade->name }}">
                                            Edit
                                        </button>
                                        <form action="/grade-subject/deleteGrade/{{ $grade->id }}" method="POST" id="deleteForm{{ $grade->id }}" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        
                                        <button type="button" class="btn btn-outline-warning" onclick="confirmDelete({{ $grade->id }})">Delete</button>
                                        
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

<script>
    //Grade Update form fill
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('grade-update');
        const input = modal.querySelector('#grade-name');
        const form = modal.querySelector('form');

        document.querySelectorAll('.edit-grade-btn').forEach(button => {
            button.addEventListener('click', () => {
                const gradeId = button.getAttribute('data-id');
                const gradeName = button.getAttribute('data-name');

                // Set the input field with the grade name
                input.value = gradeName;
            });
        });
    });

    // Grade Update
    document.querySelectorAll('.edit-grade-btn').forEach(button => {
        button.addEventListener('click', function () {
            // Get the grade data from the data attributes
            const gradeId = this.getAttribute('data-id');
            const gradeName = this.getAttribute('data-name');
            
            // Set the form action URL to match the route
            const form = document.getElementById('updateGradeForm');
            form.action = `/grade-subject/updateGrade/${gradeId}`;
            
            // Populate the input field with the current grade name
            document.getElementById('grade-name').value = gradeName;
        });
    });

    //Grade delete
    function confirmDelete(gradeId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to undo this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + gradeId).submit();
            }
        });
    }

    //Fill update Subject Form
    document.querySelectorAll('.edit-subject-btn').forEach(button => {
        button.addEventListener('click', function () {
            // Get the subject data from the data attributes
            const subjectId = this.getAttribute('data-id');
            const subjectName = this.getAttribute('data-name');
            const subjectNote = this.getAttribute('data-note');

            // Get the modal inputs
            const modal = document.querySelector('#subject-edit');
            const nameInput = modal.querySelector('#SubjectName');
            const noteInput = modal.querySelector('#SubjectNote');

            // Set the input values
            nameInput.value = subjectName;
            noteInput.value = subjectNote;

            // Optionally set the form action if needed
            const form = modal.querySelector('#updateSubjectForm');
            form.action = `/grade-subject/updateSubject/${subjectId}`; // Update with your actual route
        });
    });

    //Delete Subject
    function confirmDeleteSubject(subjectId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to undo this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteFormSubject' + subjectId).submit();
                }
                
        });

    }

</script>


@endsection