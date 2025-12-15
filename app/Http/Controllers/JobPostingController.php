<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostingController extends Controller
{
    // ... existing code ...

    /**
     * Show public job listings (for everyone)
     */
    public function publicIndex(Request $request)
    {
        $query = JobPosting::where('status', 'approved')
            ->where(function ($q) {
                $q->whereNull('deadline')
                    ->orWhere('deadline', '>=', now());
            });

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                    ->orWhere('job_description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by industry
        if ($request->has('industry') && $request->industry != 'All Industries') {
            $query->where('industry', $request->industry);
        }

        // Filter by job type
        if ($request->has('job_type') && $request->job_type != 'All Job Types') {
            $query->where('job_type', $request->job_type);
        }

        $jobs = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('jobs.public-index', compact('jobs'));
    }

    /**
     * Show single job posting (public)
     */
    public function publicShow(JobPosting $job)
    {
        // Only show approved jobs to public
        if ($job->status !== 'approved') {
            abort(404);
        }

        // Check if job is expired
        if ($job->deadline && $job->deadline < now()) {
            return view('jobs.expired', compact('job'));
        }

        $job->incrementViews();

        return view('jobs.public-show', compact('job'));
    }

    /**
     * Display job listings for job seekers (authenticated)
     */
    public function jobSeekerIndex(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'job_seeker') {
            return redirect()->route('dashboard');
        }

        $jobs = JobPosting::where('status', 'approved')
            ->where(function ($query) {
                $query->whereNull('deadline')
                    ->orWhere('deadline', '>=', now());
            })
            ->latest()
            ->paginate(15);

        return view('jobs.job-seeker-index', compact('jobs'));
    }
}
