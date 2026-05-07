@extends('layouts.app')

@section('title', 'My Profile')
@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-md-6">
            <div class="stat-card">
                <h5 class="mb-3"><i class="fas fa-user me-2 text-primary"></i> Personal Information</h5>
                <div class="mb-3">
                    <label class="text-muted small">Full Name</label>
                    <p class="fw-medium">{{ $student->first_name ?? '' }} {{ $student->last_name ?? '' }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Student ID</label>
                    <p class="fw-medium">{{ $student->student_id ?? 'N/A' }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Email</label>
                    <p class="fw-medium">{{ Auth::user()->email }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Program</label>
                    <p class="fw-medium">{{ $student->program ?? 'Not assigned' }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Year Level</label>
                    <p class="fw-medium">{{ $student->year_level ?? 'Not assigned' }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Phone</label>
                    <p class="fw-medium">{{ $student->phone ?? 'Not provided' }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Address</label>
                    <p class="fw-medium">{{ $student->address ?? 'Not provided' }}</p>
                </div>
                <button class="btn btn-outline-gradient" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="fas fa-edit me-2"></i> Edit Profile
                </button>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Change Password Section -->
            <div class="stat-card">
                <h5 class="mb-3"><i class="fas fa-key me-2 text-primary"></i> Change Password</h5>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                    <form method="POST" action="/student/password">                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control form-control-custom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control form-control-custom" required>
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-custom" required>
                    </div>
                    <button type="submit" class="btn btn-gradient w-100">
                        <i class="fas fa-save me-2"></i> Update Password
                    </button>
                </form>
            </div>
            
            <!-- Academic Advisor -->
            <div class="stat-card mt-4">
                <h5 class="mb-3"><i class="fas fa-chalkboard-user me-2 text-primary"></i> Academic Advisor</h5>
                <div class="mb-2">
                    <label class="text-muted small">Name</label>
                    <p class="fw-medium">{{ $student->advisor_name ?? 'Dr. Sarah Johnson' }}</p>
                </div>
                <div class="mb-2">
                    <label class="text-muted small">Email</label>
                    <p class="fw-medium">{{ $student->advisor_email ?? 'sjohnson@university.edu' }}</p>
                </div>
                <button class="btn btn-sm btn-outline-gradient">
                    <i class="fas fa-envelope me-2"></i> Contact Advisor
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Edit Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('student.profile.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control form-control-custom" value="{{ $student->phone ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="3" class="form-control form-control-custom">{{ $student->address ?? '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 