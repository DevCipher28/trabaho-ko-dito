<!DOCTYPE html>
<html>

<head>
    <title>Browse Jobs - Trabaho Ko, Dito!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-4">
            <a href="/" class="text-xl font-semibold text-[#f53003]">← Back to Home</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Browse Jobs in Catanduanes</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($jobs as $job)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold">{{ $job->job_title }}</h3>
                    <p class="text-gray-600">{{ $job->employer->company_name ?? $job->employer->name }}</p>
                    <p class="text-gray-500 text-sm mt-2">{{ $job->location }}</p>
                    <a href="{{ url('/jobs/' . $job->id) }}"
                        class="mt-4 inline-block px-4 py-2 bg-[#f53003] text-white rounded hover:bg-[#d42a00]">
                        View Details
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $jobs->links() }}
        </div>
    </div>
</body>

</html>
