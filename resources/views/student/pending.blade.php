@extends('layouts.app')

@section('title', 'Pending Approvals')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Pending Student Approvals</h2>
            <p class="text-muted">Review and approve student registration requests</p>
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
                            <th>Year Level</th>
                            <th>Registered</th>
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
                            <td>{{ $student->year_level }}</td>
                            <td>{{ $student->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.students.approve', $student) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this student?')">
                                            <i class="fas fa-check me-1"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.students.reject', $student) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Reject this student? This action cannot be undone.')">
                                            <i class="fas fa-times me-1"></i> Reject
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                <h5>No Pending Approvals</h5>
                <p class="text-muted">All student registrations have been reviewed.</p>
            </div>
        @endif
    </div>
</div>
@endsection