<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Trabaho Ko, Dito!</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-xl font-semibold text-[#f53003]">Trabaho Ko, Dito!</a>
                    <span class="text-gray-600">Admin Dashboard</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.job-approvals') }}" class="text-gray-700 hover:text-[#f53003]">Job
                        Approvals</a>
                    <a href="{{ route('admin.users') }}" class="text-gray-700 hover:text-[#f53003]">Users</a>
                    <a href="{{ route('admin.analytics') }}" class="text-gray-700 hover:text-[#f53003]">Analytics</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-[#f53003]">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-blue-600">{{ $stats['pending_jobs'] }}</div>
                <div class="text-gray-600 mt-2">Pending Jobs</div>
                <a href="{{ route('admin.job-approvals') }}" class="text-blue-500 text-sm mt-2 inline-block">View →</a>
            </div>

            <div class="stat-card bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-green-600">{{ $stats['total_jobs'] }}</div>
                <div class="text-gray-600 mt-2">Total Jobs</div>
            </div>

            <div class="stat-card bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-purple-600">{{ $stats['total_users'] }}</div>
                <div class="text-gray-600 mt-2">Total Users</div>
                <a href="{{ route('admin.users') }}" class="text-purple-500 text-sm mt-2 inline-block">View →</a>
            </div>

            <div class="stat-card bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-orange-600">{{ $stats['total_applications'] }}</div>
                <div class="text-gray-600 mt-2">Total Applications</div>
            </div>
        </div>

        <!-- Recent Jobs -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Job Postings</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date Posted</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($recentJobs as $job)
                            <tr>
                                <td class="px-4 py-3">{{ $job->job_title }}</td>
                                <td class="px-4 py-3">{{ $job->employer->company_name ?? $job->employer->name }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                    {{ $job->status == 'approved'
                                        ? 'bg-green-100 text-green-800'
                                        : ($job->status == 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $job->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Applications</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Seeker</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date Applied
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($recentApplications as $application)
                            <tr>
                                <td class="px-4 py-3">{{ $application->jobSeeker->name }}</td>
                                <td class="px-4 py-3">{{ $application->jobPosting->job_title }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                    {{ $application->status == 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($application->status == 'shortlisted'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $application->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
