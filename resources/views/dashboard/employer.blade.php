<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employer Dashboard - Trabaho Ko, Dito!</title>

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
                    <span class="text-gray-600">Employer Dashboard</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('my-job-postings.index') }}" class="text-gray-700 hover:text-[#f53003]">My
                        Jobs</a>
                    <a href="{{ route('employer.applications') }}"
                        class="text-gray-700 hover:text-[#f53003]">Applications</a>
                    <a href="{{ route('company.profile') }}" class="text-gray-700 hover:text-[#f53003]">Company
                        Profile</a>
                    <a href="/" class="text-gray-700 hover:text-[#f53003]">Home</a>
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
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Employer Dashboard</h1>

        <!-- Welcome Message -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-blue-900 mb-2">Welcome,
                {{ auth()->user()->company_name ?? auth()->user()->name }}!</h2>
            <p class="text-blue-700">Manage your job postings and applications here.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-green-600">{{ $stats['active_jobs'] }}</div>
                <div class="text-gray-600 mt-2">Active Jobs</div>
            </div>

            <div class="stat-card bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending_jobs'] }}</div>
                <div class="text-gray-600 mt-2">Pending Approval</div>
            </div>

            <div class="stat-card bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-blue-600">{{ $stats['total_applications'] }}</div>
                <div class="text-gray-600 mt-2">Total Applications</div>
                <a href="{{ route('employer.applications') }}" class="text-blue-500 text-sm mt-2 inline-block">View
                    →</a>
            </div>

            <div class="stat-card bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-purple-600">{{ $stats['pending_applications'] }}</div>
                <div class="text-gray-600 mt-2">Pending Review</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('my-job-postings.create') }}"
                        class="block w-full px-4 py-3 bg-[#f53003] text-white text-center rounded-md hover:bg-[#d42a00] transition">
                        Post New Job
                    </a>
                    <a href="{{ route('employer.applications') }}"
                        class="block w-full px-4 py-3 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 transition">
                        Review Applications
                    </a>
                    <a href="{{ route('company.profile') }}"
                        class="block w-full px-4 py-3 bg-green-600 text-white text-center rounded-md hover:bg-green-700 transition">
                        Update Company Profile
                    </a>
                </div>
            </div>

            <!-- Recent Jobs -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Job Postings</h2>
                @if ($jobs->count() > 0)
                    <div class="space-y-4">
                        @foreach ($jobs as $job)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $job->job_title }}</h3>
                                        <p class="text-sm text-gray-600">{{ $job->location }}</p>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                    {{ $job->status == 'approved'
                                        ? 'bg-green-100 text-green-800'
                                        : ($job->status == 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </div>
                                <div class="mt-2 flex space-x-2">
                                    <a href="{{ route('my-job-postings.edit', $job) }}"
                                        class="text-blue-600 text-sm hover:underline">Edit</a>
                                    <a href="{{ route('employer.job-applications', $job->id) }}"
                                        class="text-green-600 text-sm hover:underline">View Applications</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No job postings yet.</p>
                    <a href="{{ route('my-job-postings.create') }}"
                        class="block w-full px-4 py-2 bg-[#f53003] text-white text-center rounded-md hover:bg-[#d42a00] transition">
                        Create Your First Job Posting
                    </a>
                @endif
            </div>
        </div>

        <!-- Recent Applications -->
        @if ($applications->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Applications</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Seeker
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date Applied
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($applications as $application)
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
                                    <td class="px-4 py-3">
                                        <a href="#" class="text-blue-600 text-sm hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</body>

</html>
