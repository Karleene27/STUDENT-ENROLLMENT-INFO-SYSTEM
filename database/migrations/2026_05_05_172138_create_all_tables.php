<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'student'])->default('student');
            $table->rememberToken();
            $table->timestamps();
        });

        // Password reset tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Students
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('date_of_birth');
            $table->string('program');
            $table->enum('year_level', ['Freshman', 'Sophomore', 'Junior', 'Senior']);
            $table->enum('status', ['Active', 'Inactive', 'Pending'])->default('Active');
            $table->decimal('gpa', 3, 2)->default(0.00);
            $table->string('advisor_name')->nullable();
            $table->string('advisor_email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        // Departments
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('dept_code')->unique();
            $table->string('dept_name');
            $table->string('chairperson')->nullable();
            $table->timestamps();
        });

        // Courses
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('credits');
            $table->integer('capacity')->default(30);
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['Open', 'Limited', 'Full', 'Closed'])->default('Open');
            $table->string('semester');
            $table->integer('year');
            $table->timestamps();
        });

        // Sections
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('section_code');
            $table->string('schedule_time');
            $table->string('schedule_days');
            $table->string('room');
            $table->string('instructor');
            $table->integer('capacity')->default(30);
            $table->integer('enrolled_count')->default(0);
            $table->enum('status', ['Open', 'Limited', 'Full'])->default('Open');
            $table->timestamps();
        });

        // Enrollments (no grade columns)
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->date('enrollment_date');
            $table->enum('status', ['Enrolled', 'Pending', 'Dropped', 'Completed'])->default('Enrolled');
            $table->timestamps();
        });

        // Payments (includes reference_number)
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('enrollment_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('reference_number')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('payments');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('students');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
};