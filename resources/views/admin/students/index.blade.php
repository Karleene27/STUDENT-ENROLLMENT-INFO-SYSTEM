@extends('layouts.app')

@section('title', 'Manage Students')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Manage Students</h2>
            <p class="text-muted">View and manage all student records</p>
        </div>
        <a href="{{ route('admin.students.create') }}" class="btn btn-gradient">
            <i class="fas fa-plus me-2"></i> Add New Student
        </a>
    </div>
    
    <div class="stat-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Program</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students ?? [] as $student)
                    <tr>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->user->email ?? 'N/A' }}</td>
                        <td>{{ $student->program }}</td>
                        <td>
                            @if($student->status == 'Active')
                                <span class="badge-enrolled">Active</span>
                            @elseif($student->status == 'Pending')
                                <span class="badge-pending">Pending</span>
                            @else
                                <span class="badge-dropped">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteStudent({{ $student->id }})" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No students found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $students->onEachSide(1)->links('vendor.pagination.compact') }}
        </div>
    </div>
</div>

<script>
function deleteStudent(id) {
    if(confirm('Are you sure you want to delete this student?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>

@foreach($students ?? [] as $student)
<form id="delete-form-{{ $student->id }}" action="{{ route('admin.students.destroy', $student) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endforeach
@endsection