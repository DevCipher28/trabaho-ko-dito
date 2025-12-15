<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public Job Routes (accessible to everyone)
Route::get('/jobs', [JobPostingController::class, 'publicIndex'])->name('jobs.public');
Route::get('/jobs/{job}', [JobPostingController::class, 'publicShow'])->name('jobs.show');

// Dashboard with role-based redirection
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Settings routes (keep existing)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// Job Seeker Routes - FIXED
Route::middleware(['auth', 'verified', 'role:job_seeker'])->group(function () {
    // Job seeker applications
    Route::get('/my-job-applications', [JobApplicationController::class, 'index'])->name('job-seeker.applications');
    Route::get('/jobs/{job}/apply', [JobApplicationController::class, 'create'])->name('job-seeker.applications.create');
    Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('job-seeker.applications.store');

    // View all jobs
    Route::get('/all-jobs', [JobPostingController::class, 'jobSeekerIndex'])->name('job-seeker.jobs');
});

// Employer Routes
Route::middleware(['auth', 'verified', 'role:employer'])->group(function () {
    // Job postings
    Route::resource('my-job-postings', JobPostingController::class)->except(['show']);

    // Applications
    Route::get('/employer-applications', [JobApplicationController::class, 'employerIndex'])->name('employer.applications');
    Route::get('/my-job-postings/{job}/applications', [JobApplicationController::class, 'employerJobApplications'])->name('employer.job-applications');

    // Application status update
    Route::patch('/applications/{application}/status', [JobApplicationController::class, 'updateStatus'])->name('applications.updateStatus');

    // Company profile
    Route::get('/company-profile', [DashboardController::class, 'companyProfile'])->name('company.profile');
    Route::put('/company-profile', [DashboardController::class, 'updateCompanyProfile'])->name('company.profile.update');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/job-approvals', [AdminController::class, 'jobApprovals'])->name('admin.job-approvals');
    Route::post('/admin/jobs/{job}/approve', [AdminController::class, 'approveJob'])->name('admin.jobs.approve');
    Route::post('/admin/jobs/{job}/reject', [AdminController::class, 'rejectJob'])->name('admin.jobs.reject');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{user}/change-role', [AdminController::class, 'changeUserRole'])->name('admin.users.change-role');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
});
