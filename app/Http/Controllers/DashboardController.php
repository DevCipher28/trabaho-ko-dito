<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        }

        if ($user->role === 'employer') {
            return $this->employerDashboard($user);
        }

        // Job seeker dashboard
        return $this->jobSeekerDashboard($user);
    }

    private function adminDashboard()
    {
        $stats = [
            'pending_jobs' => JobPosting::where('status', 'pending')->count(),
            'total_jobs' => JobPosting::count(),
            'total_users' => User::count(),
            'total_applications' => JobApplication::count(),
        ];

        $recentJobs = JobPosting::with('employer')->latest()->take(5)->get();
        $recentApplications = JobApplication::with(['jobPosting', 'jobSeeker'])->latest()->take(5)->get();

        return view('dashboard.admin', compact('stats', 'recentJobs', 'recentApplications'));
    }

    private function employerDashboard($user)
    {
        $stats = [
            'active_jobs' => $user->jobPostings()->where('status', 'approved')->count(),
            'pending_jobs' => $user->jobPostings()->where('status', 'pending')->count(),
            'total_applications' => JobApplication::whereIn('job_posting_id', $user->jobPostings()->pluck('id'))->count(),
            'pending_applications' => JobApplication::whereIn('job_posting_id', $user->jobPostings()->pluck('id'))
                ->where('status', 'pending')->count(),
        ];

        $jobs = $user->jobPostings()->latest()->take(5)->get();
        $applications = JobApplication::whereIn('job_posting_id', $user->jobPostings()->pluck('id'))
            ->with('jobSeeker')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.employer', compact('stats', 'jobs', 'applications'));
    }

    private function jobSeekerDashboard($user)
    {
        $stats = [
            'applications' => $user->applications()->count(),
            'shortlisted' => $user->applications()->where('status', 'shortlisted')->count(),
            'pending' => $user->applications()->where('status', 'pending')->count(),
        ];

        $applications = $user->applications()->with('jobPosting.employer')->latest()->take(5)->get();
        $recommendedJobs = JobPosting::where('status', 'approved')
            ->where(function ($query) {
                $query->whereNull('deadline')
                    ->orWhere('deadline', '>=', now());
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.seeker', compact('stats', 'applications', 'recommendedJobs'));
    }

    public function companyProfile()
    {
        $user = Auth::user();
        return view('company.profile', compact('user'));
    }

    public function updateCompanyProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        $user->update($validated);

        return redirect()->route('company.profile')->with('success', 'Company profile updated successfully!');
    }
}
