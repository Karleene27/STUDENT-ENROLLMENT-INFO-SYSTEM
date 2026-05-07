<?php

use App\Http\Controllers\Admin\StudentManagementController;

Route::get('/pending-test', [StudentManagementController::class, 'pending']);