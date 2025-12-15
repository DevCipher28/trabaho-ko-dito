<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trabaho Ko, Dito! - CatSU Job Portal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS CDN (temporary solution until Vite is set up) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#f53003',
                        'primary-dark': '#FF4433',
                    }
                }
            }
        }
    </script>

    <!-- Custom styles -->
    <style>
        .job-card {
            transition: all 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .category-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .type-badge {
            background-color: #3b82f6;
            color: white;
        }

        .salary-badge {
            background-color: #10b981;
            color: white;
        }

        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            line-height: 1.5;
        }
    </style>
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-[#e3e3e0]">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-xl font-semibold text-[#f53003]">
                        Trabaho Ko, Dito!
                    </a>
                    <div class="hidden md:flex space-x-6">
                        <a href="/" class="text-[#1b1b18] hover:text-[#f53003]">Home</a>
                        <a href="#jobs" class="text-[#1b1b18] hover:text-[#f53003]">Jobs</a>
                        <a href="#employers" class="text-[#1b1b18] hover:text-[#f53003]">For Employers</a>
                        <a href="#about" class="text-[#1b1b18] hover:text-[#f53003]">About</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-4 py-2 bg-[#1b1b18] text-white rounded-md hover:bg-black transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-[#1b1b18] hover:text-[#f53003]">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 bg-[#f53003] text-white rounded-md hover:bg-[#d42a00] transition">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-[#fff2f2] to-[#FDFDFC] py-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 text-[#1b1b18]">
                    Find Your Dream Job in Catanduanes
                </h1>
                <p class="text-xl text-[#706f6c] mb-8 max-w-2xl mx-auto">
                    Connecting CatSU students, graduates, and local residents with job opportunities in Catanduanes and
                    surrounding regions.
                </p>
                <div class="max-w-md mx-auto">
                    <form action="#jobs" method="GET" class="flex gap-2">
                        <input type="text" name="search" placeholder="Search jobs by title, keyword, or company..."
                            class="flex-1 px-4 py-3 rounded-lg border border-[#e3e3e0] bg-white text-[#1b1b18] focus:outline-none focus:ring-2 focus:ring-[#f53003]">
                        <button type="submit"
                            class="px-6 py-3 bg-[#f53003] text-white rounded-lg hover:bg-[#d42a00] transition">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Listings Section -->
    <div id="jobs" class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-[#1b1b18]">Recent Job Postings</h2>
                <div class="flex gap-4">
                    <select class="px-4 py-2 rounded-lg border border-[#e3e3e0] bg-white text-[#1b1b18]">
                        <option>All Industries</option>
                        <option>Education</option>
                        <option>Healthcare</option>
                        <option>Government</option>
                        <option>Business</option>
                        <option>Technology</option>
                    </select>
                    <select class="px-4 py-2 rounded-lg border border-[#e3e3e0] bg-white text-[#1b1b18]">
                        <option>All Job Types</option>
                        <option>Full-time</option>
                        <option>Part-time</option>
                        <option>Contract</option>
                        <option>Internship</option>
                        <option>Remote</option>
                    </select>
                </div>
            </div>

            <!-- Job Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    use App\Models\JobPosting;
                    $jobs = JobPosting::where('status', 'approved')
                        ->where(function ($query) {
                            $query->whereNull('deadline')->orWhere('deadline', '>=', now());
                        })
                        ->orderBy('created_at', 'desc')
                        ->take(9)
                        ->get();
                @endphp

                @if ($jobs->count() > 0)
                    @foreach ($jobs as $job)
                        <div class="job-card bg-white rounded-lg border border-[#e3e3e0] p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-[#1b1b18] mb-1">
                                        {{ $job->job_title }}</h3>
                                    <p class="text-[#706f6c]">
                                        {{ $job->employer->company_name ?? $job->employer->name }}</p>
                                </div>
                                <span
                                    class="category-badge type-badge">{{ ucfirst(str_replace('-', ' ', $job->job_type)) }}</span>
                            </div>

                            <p class="text-[#1b1b18] mb-4 line-clamp-3">
                                {{ Str::limit($job->job_description, 150) }}</p>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-[#706f6c]">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $job->location }}
                                </div>
                                @if ($job->salary_min && $job->salary_max)
                                    <div class="flex items-center text-sm text-[#706f6c]">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        ₱{{ number_format($job->salary_min) }} - ₱{{ number_format($job->salary_max) }}
                                    </div>
                                @endif
                                @if ($job->deadline)
                                    <div class="flex items-center text-sm text-[#706f6c]">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Apply until: {{ $job->deadline->format('M d, Y') }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex justify-between items-center">
                                @auth
                                    @if (auth()->user()->role === 'job_seeker')
                                        <a href="{{ url('/jobs/' . $job->id . '/apply') }}"
                                            class="px-4 py-2 bg-[#f53003] text-white rounded-md hover:bg-[#d42a00] transition">
                                            Apply Now
                                        </a>
                                    @else
                                        <a href="{{ url('/jobs/' . $job->id) }}"
                                            class="px-4 py-2 bg-[#f53003] text-white rounded-md hover:bg-[#d42a00] transition">
                                            View Details
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="px-4 py-2 bg-[#f53003] text-white rounded-md hover:bg-[#d42a00] transition">
                                        Login to Apply
                                    </a>
                                @endauth
                                <a href="{{ url('/jobs/' . $job->id) }}"
                                    class="px-4 py-2 border border-[#e3e3e0] text-[#1b1b18] rounded-md hover:bg-[#FDFDFC] transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-3 text-center py-12">
                        <p class="text-gray-500 text-lg">No job postings available at the moment. Check back soon!</p>
                    </div>
                @endif
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('login') }}"
                    class="inline-block px-6 py-3 bg-[#1b1b18] text-white rounded-lg hover:bg-black transition">
                    View All Jobs
                </a>
            </div>
        </div>
    </div>

    <!-- For Employers Section -->
    <div id="employers" class="py-12 bg-[#FDFDFC]">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-[#1b1b18]">For Employers</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-white p-6 rounded-lg border border-[#e3e3e0]">
                        <div class="text-[#f53003] text-4xl mb-4">1</div>
                        <h3 class="text-xl font-semibold mb-2 text-[#1b1b18]">Post Jobs</h3>
                        <p class="text-[#706f6c]">Create detailed job listings to attract qualified candidates</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-white p-6 rounded-lg border border-[#e3e3e0]">
                        <div class="text-[#f53003] text-4xl mb-4">2</div>
                        <h3 class="text-xl font-semibold mb-2 text-[#1b1b18]">Review Applications</h3>
                        <p class="text-[#706f6c]">Manage applications and filter candidates efficiently</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-white p-6 rounded-lg border border-[#e3e3e0]">
                        <div class="text-[#f53003] text-4xl mb-4">3</div>
                        <h3 class="text-xl font-semibold mb-2 text-[#1b1b18]">Hire Talent</h3>
                        <p class="text-[#706f6c]">Connect with CatSU graduates and local professionals</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8">
                @auth
                    @if (auth()->user()->role === 'employer')
                        <a href="{{ url('/dashboard') }}"
                            class="inline-block px-6 py-3 bg-[#f53003] text-white rounded-lg hover:bg-[#d42a00] transition">
                            Post a Job
                        </a>
                    @else
                        <a href="{{ url('/dashboard') }}"
                            class="inline-block px-6 py-3 bg-[#f53003] text-white rounded-lg hover:bg-[#d42a00] transition">
                            Become an Employer
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}"
                        class="inline-block px-6 py-3 bg-[#f53003] text-white rounded-lg hover:bg-[#d42a00] transition">
                        Register as Employer
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#1b1b18] text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-xl font-semibold text-[#FF4433]">Trabaho Ko, Dito!</h3>
                    <p class="text-gray-400 mt-2">CatSU Job Portal System</p>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-gray-400">Catanduanes State University</p>
                    <p class="text-gray-400">Virac, Catanduanes</p>
                    <p class="text-gray-400 mt-2">© 2025 All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Simple search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.querySelector('form[action="#jobs"]');
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const searchTerm = this.querySelector('input[name="search"]').value.toLowerCase();
                    const jobCards = document.querySelectorAll('.job-card');

                    jobCards.forEach(card => {
                        const title = card.querySelector('h3').textContent.toLowerCase();
                        const company = card.querySelector('p').textContent.toLowerCase();
                        const description = card.querySelector('p.line-clamp-3').textContent
                            .toLowerCase();

                        if (title.includes(searchTerm) || company.includes(searchTerm) ||
                            description.includes(searchTerm)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>
