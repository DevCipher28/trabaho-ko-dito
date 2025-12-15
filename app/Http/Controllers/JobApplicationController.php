<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource (for job seekers).
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'job_seeker') {
            $applications = $user->applications()->with('jobPosting.employer')->latest()->paginate(10);
            return view('applications.index', compact('applications'));
        }

        return redirect()->route('dashboard');
    }

    /**
     * Show applications for an employer.
     */
    public function employerIndex($jobId = null)
    {
        $user = Auth::user();

        if ($user->role !== 'employer') {
            return redirect()->route('dashboard');
        }

        $query = JobApplication::whereHas('jobPosting', function ($query) use ($user) {
            $query->where('employer_id', $user->id);
        })->with(['jobPosting', 'jobSeeker']);

        if ($jobId) {
            $query->where('job_posting_id', $jobId);
        }

        $applications = $query->latest()->paginate(10);

        return view('applications.employer-index', compact('applications', 'jobId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($jobId)
    {
        $user = Auth::user();
        if ($user->role !== 'job_seeker') {
            return redirect()->route('dashboard');
        }

        $job = JobPosting::findOrFail($jobId);

        // Check if already applied
        $existingApplication = JobApplication::where('job_posting_id', $jobId)
            ->where('job_seeker_id', $user->id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

        // Check if job is approved
        if ($job->status !== 'approved') {
            return redirect()->back()->with('error', 'This job is not available for application.');
        }

        // Check if job is expired
        if ($job->deadline && $job->deadline < now()) {
            return redirect()->back()->with('error', 'The application deadline has passed.');
        }

        return view('applications.create', compact('job'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        $user = Auth::user();
        if ($user->role !== 'job_seeker') {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'cover_letter' => 'required|string|min:100',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $job = JobPosting::findOrFail($jobId);

        // Check if already applied
        $existingApplication = JobApplication::where('job_posting_id', $jobId)
            ->where('job_seeker_id', $user->id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

        // Upload resume
        $resumePath = $request->file('resume')->store('resumes', 'public');

        $application = new JobApplication();
        $application->job_posting_id = $jobId;
        $application->job_seeker_id = $user->id;
        $application->cover_letter = $validated['cover_letter'];
        $application->resume_path = $resumePath;
        $application->save();

        return redirect()->route('applications.index')->with('success', 'Application submitted successfully!');
    }

    /**
     * Update application status.
     */
    public function updateStatus(Request $request, JobApplication $application)
    {
        $user = Auth::user();

        // Only employer or admin can update status
        if ($user->role !== 'employer' && $user->role !== 'admin') {
            abort(403);
        }

        if ($user->role === 'employer' && $application->jobPosting->employer_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,rejected,hired',
        ]);

        $application->status = $validated['status'];
        $application->save();

        return redirect()->back()->with('success', 'Application status updated!');
    }

    /**
     * Download resume.
     */
    public function downloadResume(JobApplication $application)
    {
        $user = Auth::user();

        // Check permissions
        if (
            $user->id !== $application->job_seeker_id &&
            $user->id !== $application->jobPosting->employer_id &&
            $user->role !== 'admin'
        ) {
            abort(403);
        }

        if (!$application->resume_path) {
            return redirect()->back()->with('error', 'No resume available.');
        }

        return Storage::disk('public')->download($application->resume_path);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $application)
    {
        $user = Auth::user();

        if ($user->id !== $application->job_seeker_id) {
            abort(403);
        }

        // Delete resume file if exists
        if ($application->resume_path) {
            Storage::disk('public')->delete($application->resume_path);
        }

        $application->delete();

        return redirect()->route('applications.index')->with('success', 'Application withdrawn successfully!');
    }

    public function employerJobApplications($jobId)
    {
        $user = Auth::user();

        if ($user->role !== 'employer') {
            return redirect()->route('dashboard');
        }

        $applications = JobApplication::where('job_posting_id', $jobId)
            ->whereHas('jobPosting', function ($query) use ($user) {
                $query->where('employer_id', $user->id);
            })
            ->with(['jobPosting', 'jobSeeker'])
            ->latest()
            ->paginate(10);

        return view('applications.employer-index', compact('applications'));
    }
}
