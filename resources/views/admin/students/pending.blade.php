@extends('layouts.app')

@section('title', 'Pending Approvals')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Pending Student Approvals</h2>
            <p class="text-muted">Review and approve freshman enrollment applications</p>
        </div>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Students
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="stat-card">
        @if($pendingStudents->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Program</th>
                            <th>Applied</th>
                            <th>Documents</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingStudents as $student)
                        <tr>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td>{{ $student->user->email }}</td>
                            <td>{{ $student->program }}</td>
                            <td>{{ $student->created_at->format('M d, Y') }}</td>
                            <td class="documents-cell">
                                <div class="d-flex gap-1 flex-wrap">
                                    @if($student->psa_file)
                                        <a href="{{ Storage::url($student->psa_file) }}" target="_blank" class="btn btn-xs btn-outline-info">PSA</a>
                                    @endif
                                    @if($student->good_moral_file)
                                        <a href="{{ Storage::url($student->good_moral_file) }}" target="_blank" class="btn btn-xs btn-outline-info">Good Moral</a>
                                    @endif
                                    @if($student->form137_file)
                                        <a href="{{ Storage::url($student->form137_file) }}" target="_blank" class="btn btn-xs btn-outline-info">Form 137</a>
                                    @endif
                                </div>
                            </td>
                            <td class="actions-cell">
                                <div class="d-flex gap-2">
                                    <button type="button"
                                            class="btn btn-sm btn-info view-student-btn"
                                            data-student-id="{{ $student->student_id }}"
                                            data-name="{{ $student->first_name }} {{ $student->last_name }}"
                                            data-email="{{ $student->user->email }}"
                                            data-program="{{ $student->program }}"
                                            data-year-level="{{ $student->year_level }}"
                                            data-phone="{{ $student->phone ?? 'Not provided' }}"
                                            data-address="{{ $student->address ?? 'Not provided' }}"
                                            data-applied="{{ $student->created_at->format('F d, Y h:i A') }}"
                                            data-mother-name="{{ $student->mother_name ?? 'Not provided' }}"
                                            data-mother-occ="{{ $student->mother_occupation ?? 'Not provided' }}"
                                            data-father-name="{{ $student->father_name ?? 'Not provided' }}"
                                            data-father-occ="{{ $student->father_occupation ?? 'Not provided' }}"
                                            data-psa="{{ $student->psa_file ? Storage::url($student->psa_file) : '' }}"
                                            data-good-moral="{{ $student->good_moral_file ? Storage::url($student->good_moral_file) : '' }}"
                                            data-form137="{{ $student->form137_file ? Storage::url($student->form137_file) : '' }}">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                    <form action="{{ route('admin.students.approve', $student) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this student?')">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.students.reject', $student) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Reject this application?')">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $pendingStudents->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                <h5>No Pending Approvals</h5>
                <p class="text-muted">All enrollment applications have been reviewed.</p>
            </div>
        @endif
    </div>
</div>

{{-- Single Modal --}}
<div class="modal fade" id="studentDetailsModal" tabindex="-1" aria-labelledby="studentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentDetailsModalLabel">Student Application Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Personal Information</h6>
                        <p><strong>Student ID:</strong> <span id="modal-student-id"></span></p>
                        <p><strong>Name:</strong> <span id="modal-name"></span></p>
                        <p><strong>Email:</strong> <span id="modal-email"></span></p>
                        <p><strong>Program:</strong> <span id="modal-program"></span></p>
                        <p><strong>Year Level:</strong> <span id="modal-year-level"></span></p>
                        <p><strong>Phone:</strong> <span id="modal-phone"></span></p>
                        <p><strong>Address:</strong> <span id="modal-address"></span></p>
                        <p><strong>Applied on:</strong> <span id="modal-applied"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Parent/Guardian Information</h6>
                        <p><strong>Mother's Name:</strong> <span id="modal-mother-name"></span></p>
                        <p><strong>Mother's Occupation:</strong> <span id="modal-mother-occ"></span></p>
                        <p><strong>Father's Name:</strong> <span id="modal-father-name"></span></p>
                        <p><strong>Father's Occupation:</strong> <span id="modal-father-occ"></span></p>
                    </div>
                </div>
                <hr>
                <h6>Uploaded Documents</h6>
                <div id="modal-documents" class="list-group"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-student-btn');
    const modal = new bootstrap.Modal(document.getElementById('studentDetailsModal'));

    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('modal-student-id').textContent = this.dataset.studentId;
            document.getElementById('modal-name').textContent = this.dataset.name;
            document.getElementById('modal-email').textContent = this.dataset.email;
            document.getElementById('modal-program').textContent = this.dataset.program;
            document.getElementById('modal-year-level').textContent = this.dataset.yearLevel;
            document.getElementById('modal-phone').textContent = this.dataset.phone;
            document.getElementById('modal-address').textContent = this.dataset.address;
            document.getElementById('modal-applied').textContent = this.dataset.applied;
            document.getElementById('modal-mother-name').textContent = this.dataset.motherName;
            document.getElementById('modal-mother-occ').textContent = this.dataset.motherOcc;
            document.getElementById('modal-father-name').textContent = this.dataset.fatherName;
            document.getElementById('modal-father-occ').textContent = this.dataset.fatherOcc;

            const docsDiv = document.getElementById('modal-documents');
            docsDiv.innerHTML = '';
            if (this.dataset.psa) {
                docsDiv.innerHTML += `<a href="${this.dataset.psa}" target="_blank" class="list-group-item list-group-item-action">📄 PSA / Birth Certificate</a>`;
            } else {
                docsDiv.innerHTML += `<span class="list-group-item disabled">PSA / Birth Certificate – Not uploaded</span>`;
            }
            if (this.dataset.goodMoral) {
                docsDiv.innerHTML += `<a href="${this.dataset.goodMoral}" target="_blank" class="list-group-item list-group-item-action">📄 Good Moral Certificate</a>`;
            } else {
                docsDiv.innerHTML += `<span class="list-group-item disabled">Good Moral Certificate – Not uploaded</span>`;
            }
            if (this.dataset.form137) {
                docsDiv.innerHTML += `<a href="${this.dataset.form137}" target="_blank" class="list-group-item list-group-item-action">📄 Form 137 / Report Card</a>`;
            } else {
                docsDiv.innerHTML += `<span class="list-group-item disabled">Form 137 – Not uploaded</span>`;
            }

            modal.show();
        });
    });
});
</script>
@endsection