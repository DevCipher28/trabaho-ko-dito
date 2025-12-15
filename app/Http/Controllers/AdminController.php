<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show job approvals page.
     */
    public function jobApprovals()
    {
        $pendingJobs = JobPosting::where('status', 'pending')->with('employer')->latest()->paginate(10);
        $approvedJobs = JobPosting::where('status', 'approved')->with('employer')->latest()->paginate(10);
        $rejectedJobs = JobPosting::where('status', 'rejected')->with('employer')->latest()->paginate(10);

        return view('admin.job-approvals', compact('pendingJobs', 'approvedJobs', 'rejectedJobs'));
    }

    /**
     * Approve a job posting.
     */
    public function approveJob(Request $request, JobPosting $job)
    {
        $job->status = 'approved';
        $job->save();

        return redirect()->back()->with('success', 'Job approved successfully!');
    }

    /**
     * Reject a job posting.
     */
    public function rejectJob(Request $request, JobPosting $job)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $job->status = 'rejected';
        $job->save();

        return redirect()->back()->with('success', 'Job rejected successfully!');
    }

    /**
     * Show users management page.
     */
    public function users()
    {
        $users = User::latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Change user role.
     */
    public function changeUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:job_seeker,employer,admin',
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully!');
    }

    /**
     * Delete a user.
     */
    public function deleteUser(Request $request, User $user)
    {
        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    /**
     * Show analytics dashboard.
     */
    public function analytics()
    {
        $stats = [
            'total_jobs' => JobPosting::count(),
            'approved_jobs' => JobPosting::where('status', 'approved')->count(),
            'pending_jobs' => JobPosting::where('status', 'pending')->count(),
            'total_users' => User::count(),
            'job_seekers' => User::where('role', 'job_seeker')->count(),
            'employers' => User::where('role', 'employer')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'total_applications' => JobApplication::count(),
        ];

        // Recent activity
        $recentJobs = JobPosting::with('employer')->latest()->take(10)->get();
        $recentUsers = User::latest()->take(10)->get();
        $recentApplications = JobApplication::with(['jobPosting', 'jobSeeker'])->latest()->take(10)->get();

        return view('admin.analytics', compact('stats', 'recentJobs', 'recentUsers', 'recentApplications'));
    }
}
