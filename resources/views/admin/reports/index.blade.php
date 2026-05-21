@extends('layouts.app')

@section('title', 'Reports')
@section('content')
<div class="fade-in">
    <h2 class="mb-4">Generate Reports</h2>
    
    <div class="stat-card">
        <div class="row g-4">
            <div class="col-md-6">
                <form id="reportForm">
                    @csrf
                    <label class="form-label fw-bold">Report Type</label>
                    <select name="report_type" class="form-select form-control-custom mb-3" required>
                        <option value="class_roster">Class Roster</option>
                        <option value="enrollment_summary">Enrollment Summary</option>
                        <option value="course_utilization">Course Utilization</option>
                    </select>
                    
                    <label class="form-label fw-bold">Semester</label>
                    <select name="semester" class="form-select form-control-custom mb-3" required>
                        @foreach($semesters as $sem)
                            <option value="{{ $sem }}">{{ $sem }}</option>
                        @endforeach
                    </select>
                    
                    <label class="form-label fw-bold">Course</label>
                    <select name="course_id" class="form-select form-control-custom mb-3">
                        <option value="">All Courses</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->title }}</option>
                        @endforeach
                    </select>
                    
                    <label class="form-label fw-bold">Format</label>
                    <div class="d-flex gap-3 mb-4">
                        <div><input type="radio" name="format" value="pdf" checked> PDF</div>
                        <div><input type="radio" name="format" value="excel"> Excel</div>
                        <div><input type="radio" name="format" value="csv"> CSV</div>
                    </div>
                    
                    <button type="button" id="generateBtn" class="btn btn-gradient w-100 py-2">
                        <i class="fas fa-chart-line me-2"></i> Generate Report
                    </button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="bg-light rounded-3 p-4">
                    <div id="reportPreview">
                        <i class="fas fa-file-alt fa-4x text-primary mb-3 d-block text-center"></i>
                        <h6 class="text-center">Report Preview</h6>
                        <p class="text-muted small text-center">Select report options and click Generate to preview</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('generateBtn').addEventListener('click', function() {
    const form = document.getElementById('reportForm');
    const formData = new FormData(form);
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch('{{ route("admin.reports.generate") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('reportPreview').innerHTML = data.html;
    })
    .catch(error => {
        document.getElementById('reportPreview').innerHTML = '<div class="alert alert-danger">Error loading report.</div>';
    });
});
</script>
@endsection