<!DOCTYPE html>
<html>

<head>
    <title>My Applications - Trabaho Ko, Dito!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-[#f53003]">← Back to Dashboard</a>
                <span class="text-gray-600">My Applications</span>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">My Job Applications</h1>

        @if ($applications->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date Applied
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($applications as $application)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $application->jobPosting->job_title }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $application->jobPosting->location }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">
                                        {{ $application->jobPosting->employer->company_name ?? $application->jobPosting->employer->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $application->status == 'pending'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : ($application->status == 'reviewed'
                                        ? 'bg-blue-100 text-blue-800'
                                        : ($application->status == 'shortlisted'
                                            ? 'bg-green-100 text-green-800'
                                            : ($application->status == 'hired'
                                                ? 'bg-purple-100 text-purple-800'
                                                : 'bg-red-100 text-red-800'))) }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $application->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('jobs.show', $application->jobPosting->id) }}"
                                        class="text-blue-600 hover:underline">View Job</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $applications->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-500 text-lg mb-4">You haven't applied for any jobs yet.</p>
                <a href="{{ route('job-seeker.jobs') }}"
                    class="px-4 py-2 bg-[#f53003] text-white rounded hover:bg-[#d42a00]">
                    Browse Jobs
                </a>
            </div>
        @endif
    </div>
</body>

</html>
