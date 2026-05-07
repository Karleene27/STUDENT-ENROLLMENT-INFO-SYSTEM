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
        @if(isset($pendingStudents) && $pendingStudents->count() > 0)
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
                            <td><strong>{{ $student->student_id }}</strong></td>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td>{{ $student->user->email }}</td>
                            <td>{{ $student->program }}</td>
                            <td>{{ $student->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($student->psa_file || $student->good_moral_file || $student->form137_file)
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
                                @else
                                    <span class="text-muted">None</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $student->id }}">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                    <form action="{{ route('admin.students.approve', $student) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this student? They will receive login credentials via email.')">
                                            <i class="fas fa-check me-1"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.students.reject', $student) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Reject this application? This action cannot be undone.')">
                                            <i class="fas fa-times me-1"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal{{ $student->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Student Application Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Personal Information</h6>
                                                <p><strong>Student ID:</strong> {{ $student->student_id }}</p>
                                                <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
                                                <p><strong>Email:</strong> {{ $student->user->email }}</p>
                                                <p><strong>Program:</strong> {{ $student->program }}</p>
                                                <p><strong>Year Level:</strong> {{ $student->year_level }}</p>
                                                <p><strong>Phone:</strong> {{ $student->phone ?? 'Not provided' }}</p>
                                                <p><strong>Address:</strong> {{ $student->address ?? 'Not provided' }}</p>
                                                <p><strong>Applied on:</strong> {{ $student->created_at->format('F d, Y h:i A') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Parent/Guardian Information</h6>
                                                <p><strong>Mother's Name:</strong> {{ $student->mother_name ?? 'Not provided' }}</p>
                                                <p><strong>Mother's Occupation:</strong> {{ $student->mother_occupation ?? 'Not provided' }}</p>
                                                <p><strong>Father's Name:</strong> {{ $student->father_name ?? 'Not provided' }}</p>
                                                <p><strong>Father's Occupation:</strong> {{ $student->father_occupation ?? 'Not provided' }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <h6>Uploaded Documents</h6>
                                        <div class="list-group">
                                            @if($student->psa_file)
                                                <a href="{{ Storage::url($student->psa_file) }}" target="_blank" class="list-group-item list-group-item-action">📄 PSA / Birth Certificate</a>
                                            @else
                                                <span class="list-group-item disabled">PSA / Birth Certificate – Not uploaded</span>
                                            @endif
                                            @if($student->good_moral_file)
                                                <a href="{{ Storage::url($student->good_moral_file) }}" target="_blank" class="list-group-item list-group-item-action">📄 Good Moral Certificate</a>
                                            @else
                                                <span class="list-group-item disabled">Good Moral Certificate – Not uploaded</span>
                                            @endif
                                            @if($student->form137_file)
                                                <a href="{{ Storage::url($student->form137_file) }}" target="_blank" class="list-group-item list-group-item-action">📄 Form 137 / Report Card</a>
                                            @else
                                                <span class="list-group-item disabled">Form 137 – Not uploaded</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                <h5>No Pending Approvals</h5>
                <p class="text-muted">All enrollment applications have been reviewed.</p>
            </div>
        @endif
    </div>
</div>
@endsection