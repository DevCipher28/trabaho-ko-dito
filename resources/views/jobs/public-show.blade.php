<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $job->job_title }} - Trabaho Ko, Dito!</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $job->job_title }}</h1>
                    <p class="text-lg text-gray-600 mt-2">{{ $job->employer->company_name ?? $job->employer->name }}</p>
                    <p class="text-gray-500">{{ $job->location }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                        {{ ucfirst(str_replace('-', ' ', $job->job_type)) }}
                    </span>
                    @if ($job->salary_min && $job->salary_max)
                        <p class="mt-2 text-lg font-semibold text-green-600">
                            ₱{{ number_format($job->salary_min) }} - ₱{{ number_format($job->salary_max) }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2">📅 Application Deadline</h3>
                    <p>{{ $job->deadline ? $job->deadline->format('F d, Y') : 'Open until filled' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2">🏢 Industry</h3>
                    <p>{{ $job->industry ?? 'Not specified' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2">👁️ Views</h3>
                    <p>{{ $job->views }} views</p>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Job Description</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($job->job_description)) !!}
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Qualifications</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($job->qualifications)) !!}
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">How to Apply</h3>
                <div class="space-y-3">
                    <p><strong>Email:</strong> {{ $job->application_email }}</p>
                    @if ($job->application_phone)
                        <p><strong>Phone:</strong> {{ $job->application_phone }}</p>
                    @endif
                    <p class="text-sm text-gray-600">Send your resume and cover letter to the email above.</p>
                </div>
            </div>

            <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                <a href="{{ url('/') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                    ← Back
                </a>
                @auth
                    @if (auth()->user()->role === 'job_seeker')
                        <a href="{{ url('/jobs/' . $job->id . '/apply') }}"
                            class="px-6 py-3 bg-[#f53003] text-white rounded-md hover:bg-[#d42a00] transition font-semibold">
                            Apply for this Job
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="px-6 py-3 bg-[#f53003] text-white rounded-md hover:bg-[#d42a00] transition font-semibold">
                        Login to Apply
                    </a>
                @endauth
            </div>
        </div>
    </div>
</body>

</html>
