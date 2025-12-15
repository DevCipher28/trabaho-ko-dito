<!DOCTYPE html>
<html>

<head>
    <title>Applications - Trabaho Ko, Dito!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-[#f53003]">← Back to Dashboard</a>
                <span class="text-gray-600">Employer Applications</span>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Job Applications</h1>

        @if ($applications->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
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
                                    <div class="font-medium text-gray-900">{{ $application->jobSeeker->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $application->jobSeeker->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $application->jobPosting->job_title }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $application->jobPosting->location }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $application->status == 'pending'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : ($application->status == 'shortlisted'
                                        ? 'bg-green-100 text-green-800'
                                        : ($application->status == 'hired'
                                            ? 'bg-purple-100 text-purple-800'
                                            : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $application->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('applications.updateStatus', $application) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="text-sm border rounded p-1">
                                            <option value="pending"
                                                {{ $application->status == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="reviewed"
                                                {{ $application->status == 'reviewed' ? 'selected' : '' }}>Reviewed
                                            </option>
                                            <option value="shortlisted"
                                                {{ $application->status == 'shortlisted' ? 'selected' : '' }}>
                                                Shortlisted</option>
                                            <option value="rejected"
                                                {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected
                                            </option>
                                            <option value="hired"
                                                {{ $application->status == 'hired' ? 'selected' : '' }}>Hired</option>
                                        </select>
                                    </form>
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
                <p class="text-gray-500 text-lg mb-4">No applications received yet.</p>
                <a href="{{ route('my-job-postings.create') }}"
                    class="px-4 py-2 bg-[#f53003] text-white rounded hover:bg-[#d42a00]">
                    Create a Job Posting
                </a>
            </div>
        @endif
    </div>
</body>

</html>
