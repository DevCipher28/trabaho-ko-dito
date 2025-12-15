<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job Seeker Dashboard - Trabaho Ko, Dito!</title>

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
                    <span class="text-gray-600">Job Seeker Dashboard</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('job-seeker.applications') }}" class="text-gray-700 hover:text-[#f53003]">My
                        Applications</a>
                    <a href="/jobs" class="text-gray-700 hover:text-[#f53003]">Browse Jobs</a>
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
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Welcome, {{ auth()->user()->name }}!</h1>

        <!-- Welcome Message -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-blue-900 mb-2">Find Your Dream Job in Catanduanes</h2>
            <p class="text-blue-700">Track your applications and discover new opportunities.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-blue-600">{{ $stats['applications'] }}</div>
                <div class="text-gray-600 mt-2">Total Applications</div>
                <a href="{{ route('job-seeker.applications') }}" class="text-blue-500 text-sm mt-2 inline-block">View
                    All →</a>
            </div>

            <div class="stat-card bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-green-600">{{ $stats['shortlisted'] }}</div>
                <div class="text-gray-600 mt-2">Shortlisted</div>
            </div>

            <div class="stat-card bg-white rounded-lg shadow-md p-6">
                <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                <div class="text-gray-600 mt-2">Pending Review</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Applications -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Recent Applications</h2>
                    <a href="{{ route('job-seeker.applications') }}" class="text-blue-600 text-sm hover:underline">View
                        All</a>
                </div>

                @if ($applications->count() > 0)
                    <div class="space-y-4">
                        @foreach ($applications as $application)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">
                                            {{ $application->jobPosting->job_title }}</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $application->jobPosting->employer->company_name ?? $application->jobPosting->employer->name }}
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $application->jobPosting->location }}</p>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                    {{ $application->status == 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($application->status == 'shortlisted'
                                            ? 'bg-green-100 text-green-800'
                                            : ($application->status == 'hired'
                                                ? 'bg-purple-100 text-purple-800'
                                                : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                                <div class="mt-2 text-sm text-gray-600">
                                    Applied on: {{ $application->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-4">You haven't applied for any jobs yet.</p>
                        <a href="/jobs"
                            class="px-4 py-2 bg-[#f53003] text-white rounded-md hover:bg-[#d42a00] transition">
                            Browse Jobs
                        </a>
                    </div>
                @endif
            </div>

            <!-- Recommended Jobs -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Recommended Jobs</h2>
                    <a href="/jobs" class="text-blue-600 text-sm hover:underline">Browse All</a>
                </div>

                @if ($recommendedJobs->count() > 0)
                    <div class="space-y-4">
                        @foreach ($recommendedJobs as $job)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                                <h3 class="font-semibold text-gray-900">{{ $job->job_title }}</h3>
                                <p class="text-sm text-gray-600">
                                    {{ $job->employer->company_name ?? $job->employer->name }}</p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                        {{ ucfirst(str_replace('-', ' ', $job->job_type)) }}
                                    </span>
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">
                                        {{ $job->location }}
                                    </span>
                                    @if ($job->salary_min && $job->salary_max)
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                            ₱{{ number_format($job->salary_min) }} -
                                            ₱{{ number_format($job->salary_max) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <a href="{{ url('/jobs/' . $job->id) }}"
                                        class="text-blue-600 text-sm hover:underline">View Details</a>
                                    <a href="{{ route('job-seeker.applications.create', $job->id) }}"
                                        class="px-3 py-1 bg-[#f53003] text-white text-sm rounded hover:bg-[#d42a00] transition">
                                        Apply Now
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">No recommended jobs available at the moment.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Tips -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-yellow-900 mb-3">Job Search Tips</h3>
            <ul class="text-yellow-800 space-y-2">
                <li class="flex items-start">
                    <span class="mr-2">✓</span>
                    <span>Keep your resume updated with recent experiences</span>
                </li>
                <li class="flex items-start">
                    <span class="mr-2">✓</span>
                    <span>Write personalized cover letters for each application</span>
                </li>
                <li class="flex items-start">
                    <span class="mr-2">✓</span>
                    <span>Follow up on applications after 1-2 weeks</span>
                </li>
                <li class="flex items-start">
                    <span class="mr-2">✓</span>
                    <span>Prepare for interviews by researching the company</span>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>
