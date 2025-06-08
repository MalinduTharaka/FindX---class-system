@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title mb-1 anchor" id="basic">
                                Students
                            </h5>
                            <div class="align-items-center">
                                <select class="form-control" name="choices-single-default" id="students">
                                    <option value="">Select a student</option>
                                    @foreach ($students as $student)
                                        <option value="{{$student->id}}">{{$student->id}} - {{$student->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div> 

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1 anchor">Payment Details</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered border-primary table-centered">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Fee</th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Aug</th>
                                    <th>Sep</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dec</th>
                                </tr>
                            </thead>
                            <tbody id="paymentTableBody"></tbody>
                        </table>
                    </div>
                    <!-- Payment Button -->
                    <button id="createPaymentBtn" class="btn btn-primary mt-3">Create Payment</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    document.getElementById('students').addEventListener('change', function() {
        let studentId = this.value;
        let tableBody = document.getElementById('paymentTableBody');
        tableBody.innerHTML = '';
    
        if (studentId) {
            fetch(`/api/payments/${studentId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(assign => {
                        let row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${assign.class.name}</td>
                            <td>${assign.class.class_fee}</td>
                            ${generateCheckboxes(assign.class_id, studentId)}
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching payment data:', error));
        }
    });
    
    function generateCheckboxes(classId, studentId) {
        let checkboxes = '';
        for (let i = 1; i <= 12; i++) { 
            checkboxes += `<td><input type="checkbox" class="form-check-input payment-checkbox" data-class="${classId}" data-student="${studentId}" data-month="${i}"></td>`;
        }
    
        fetch(`/api/check-payments/${studentId}/${classId}`)
            .then(response => response.json())
            .then(payments => {
                payments.forEach(payment => {
                    let checkbox = document.querySelector(`input[data-class="${classId}"][data-student="${studentId}"][data-month="${payment.month}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                        checkbox.disabled = true;
                    }
                });
            })
            .catch(error => console.error('Error fetching payment records:', error));
    
        return checkboxes;
    }
    
    // Handle Payment Button Click
    document.getElementById('createPaymentBtn').addEventListener('click', function() {
    let selectedPayments = [];

    document.querySelectorAll('.payment-checkbox:checked:not(:disabled)').forEach(checkbox => {
        selectedPayments.push({
            student_id: checkbox.getAttribute('data-student'),
            class_id: checkbox.getAttribute('data-class'),
            month: checkbox.getAttribute('data-month'),
            total: checkbox.closest('tr').querySelector('td:nth-child(2)').textContent.trim() // Get class_fee
        });
    });

    if (selectedPayments.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No Payments Selected',
            text: 'Please select at least one payment before proceeding.',
        });
        return;
    }

    // SweetAlert Confirmation
    Swal.fire({
        title: 'Confirm Payment',
        text: "Are you sure you want to store these payments?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Confirm!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/api/store-payments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ payments: selectedPayments })
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                });
                document.getElementById('students').dispatchEvent(new Event('change')); // Refresh data
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Something went wrong while storing payments!',
                });
                console.error('Error storing payments:', error);
            });
        }
    });
});

    </script>
    
@endsection