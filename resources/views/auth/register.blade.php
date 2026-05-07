<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SEIS - Student Enrollment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .register-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            width: 100%;
            max-width: 800px;
            animation: fadeInUp 0.5s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo-icon {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .logo-icon i { font-size: 1.6rem; color: white; }
        .register-title { text-align: center; font-size: 1.4rem; font-weight: 700; background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; background-clip: text; color: transparent; margin-bottom: 0.3rem; }
        .register-subtitle { text-align: center; color: #64748b; font-size: 0.75rem; margin-bottom: 1.5rem; }
        .info-badge { background: #ecfdf5; border-left: 4px solid #22c55e; padding: 0.7rem; border-radius: 12px; margin-bottom: 1rem; font-size: 0.7rem; }
        .form-label { font-weight: 600; font-size: 0.7rem; margin-bottom: 0.3rem; color: #1e293b; display: block; }
        .form-control-custom, .form-select-custom { width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.8rem; transition: all 0.3s; }
        .form-control-custom:focus, .form-select-custom:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .btn-register { width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.7rem; border-radius: 12px; font-weight: 600; font-size: 0.85rem; color: white; transition: all 0.3s; margin-top: 0.5rem; }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .login-link { text-align: center; margin-top: 1.2rem; font-size: 0.75rem; color: #64748b; }
        .login-link a { color: #667eea; text-decoration: none; font-weight: 600; }
        .row { display: flex; flex-wrap: wrap; margin: 0 -0.5rem; }
        .col-half { flex: 0 0 50%; padding: 0 0.5rem; }
        @media (max-width: 480px) { .col-half { flex: 0 0 100%; } }
        .alert-custom { padding: 0.7rem; border-radius: 12px; font-size: 0.7rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
<div class="register-card">
    <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
    <h2 class="register-title">Student Enrollment</h2>
    <p class="register-subtitle">Create your student account</p>

    <div class="info-badge">
        <i class="fas fa-info-circle text-success me-2"></i>
        <strong>Note:</strong> Your Student ID will be automatically generated after submission.
        Account will be pending approval by the administrator.
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-custom">
            <i class="fas fa-exclamation-circle me-2"></i> Please fix the errors below.
            <ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <h5 class="mt-2 mb-2">Personal Information</h5>
        <div class="row">
            <div class="col-half"><div class="form-group"><label class="form-label">First Name <span class="text-danger">*</span></label><input type="text" name="first_name" class="form-control-custom" value="{{ old('first_name') }}" required></div></div>
            <div class="col-half"><div class="form-group"><label class="form-label">Last Name <span class="text-danger">*</span></label><input type="text" name="last_name" class="form-control-custom" value="{{ old('last_name') }}" required></div></div>
        </div>
        <div class="form-group"><label class="form-label">Display Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control-custom" value="{{ old('name') }}" placeholder="How you want to be called" required></div>
        <div class="form-group"><label class="form-label">Email Address <span class="text-danger">*</span></label><input type="email" name="email" class="form-control-custom" value="{{ old('email') }}" required></div>
        <div class="row">
            <div class="col-half"><div class="form-group"><label class="form-label">Date of Birth</label><input type="date" name="date_of_birth" class="form-control-custom" value="{{ old('date_of_birth') }}"></div></div>
            <div class="col-half"><div class="form-group"><label class="form-label">Phone Number</label><input type="text" name="phone" class="form-control-custom" value="{{ old('phone') }}" placeholder="e.g., 09123456789"></div></div>
        </div>
        <div class="row">
            <div class="col-half"><div class="form-group"><label class="form-label">Program <span class="text-danger">*</span></label><select name="program" class="form-select-custom" required>
                <option value="">Select Program</option>
                <option value="Computer Science" {{ old('program')=='Computer Science' ? 'selected' : '' }}>Computer Science</option>
                <option value="Information Technology" {{ old('program')=='Information Technology' ? 'selected' : '' }}>Information Technology</option>
                <option value="Engineering" {{ old('program')=='Engineering' ? 'selected' : '' }}>Engineering</option>
                <option value="Business Administration" {{ old('program')=='Business Administration' ? 'selected' : '' }}>Business Administration</option>
            </select></div></div>
            <div class="col-half"><div class="form-group"><label class="form-label">Year Level</label><select name="year_level" class="form-select-custom">
                <option value="Freshman" selected>Freshman (1st Year)</option>
                <option value="Sophomore">Sophomore (2nd Year)</option>
                <option value="Junior">Junior (3rd Year)</option>
                <option value="Senior">Senior (4th Year)</option>
            </select></div></div>
        </div>
        <div class="form-group"><label class="form-label">Address</label><textarea name="address" rows="2" class="form-control-custom" placeholder="Your complete address">{{ old('address') }}</textarea></div>

        <h5 class="mt-3 mb-2">Parent/Guardian Information</h5>
        <div class="row">
            <div class="col-half"><div class="form-group"><label class="form-label">Mother's Full Name</label><input type="text" name="mother_name" class="form-control-custom" value="{{ old('mother_name') }}"></div></div>
            <div class="col-half"><div class="form-group"><label class="form-label">Mother's Occupation</label><input type="text" name="mother_occupation" class="form-control-custom" value="{{ old('mother_occupation') }}"></div></div>
        </div>
        <div class="row">
            <div class="col-half"><div class="form-group"><label class="form-label">Father's Full Name</label><input type="text" name="father_name" class="form-control-custom" value="{{ old('father_name') }}"></div></div>
            <div class="col-half"><div class="form-group"><label class="form-label">Father's Occupation</label><input type="text" name="father_occupation" class="form-control-custom" value="{{ old('father_occupation') }}"></div></div>
        </div>

        <h5 class="mt-3 mb-2">Required Documents (PDF, JPG, PNG)</h5>
        <div class="form-group"><label class="form-label">PSA / Birth Certificate</label><input type="file" name="psa_file" class="form-control-custom" accept=".pdf,.jpg,.jpeg,.png"></div>
        <div class="form-group"><label class="form-label">Good Moral Certificate</label><input type="file" name="good_moral_file" class="form-control-custom" accept=".pdf,.jpg,.jpeg,.png"></div>
        <div class="form-group"><label class="form-label">Form 137 / Report Card</label><input type="file" name="form137_file" class="form-control-custom" accept=".pdf,.jpg,.jpeg,.png"></div>

        <div class="info-badge mt-3">
            <i class="fas fa-key text-warning me-2"></i>
            <strong>Account Setup:</strong> You don't need to create a password now. After admin approval, you will receive login credentials.
        </div>

        <button type="submit" class="btn-register"><i class="fas fa-paper-plane me-2"></i> Submit Enrollment Application</button>
    </form>

    <div class="login-link">Already have an account? <a href="{{ route('login') }}">Login here</a></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>