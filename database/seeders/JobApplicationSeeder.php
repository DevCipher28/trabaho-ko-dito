<?php

namespace Database\Seeders;

use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        // Get job seekers
        $jobSeekers = User::where('role', 'job_seeker')->get();

        // Get approved job postings
        $jobPostings = JobPosting::where('status', 'approved')->get();

        if ($jobSeekers->isEmpty() || $jobPostings->isEmpty()) {
            $this->command->warn('⚠️ Need job seekers and approved job postings to seed applications.');
            return;
        }

        $applicationData = [
            [
                'cover_letter' => "Dear Hiring Manager,\n\nI am writing to express my interest in the Mathematics Teacher position. With my Bachelor's Degree in Mathematics Education and LET license, I believe I have the qualifications to contribute to your school's academic excellence. I have 3 years of teaching experience and a passion for making math accessible to all students.\n\nThank you for considering my application.\n\nSincerely,\n[Applicant Name]",
                'status' => 'pending',
                'resume_path' => 'resumes/math_teacher_cv.pdf',
            ],
            [
                'cover_letter' => "Dear IT Department,\n\nI am excited to apply for the IT Support Specialist position. I recently graduated with a Bachelor's in Computer Science and have completed internships where I gained hands-on experience in troubleshooting hardware/software issues. I am eager to contribute to your university's technology infrastructure.\n\nBest regards,\n[Applicant Name]",
                'status' => 'reviewed',
                'resume_path' => 'resumes/it_support_cv.pdf',
            ],
            [
                'cover_letter' => "Dear Medical Director,\n\nAs a Registered Nurse with 2 years of hospital experience, I am applying for the Nurse position at your medical center. I am passionate about providing compassionate patient care and have experience in various hospital departments. I hold BLS certification and am eager to join your healthcare team.\n\nRespectfully,\n[Applicant Name]",
                'status' => 'shortlisted',
                'resume_path' => 'resumes/nurse_cv.pdf',
            ],
            [
                'cover_letter' => "Dear Accounting Department,\n\nI am a Certified Public Accountant with 4 years of experience in financial management. I am applying for the Accountant position to contribute to your municipal office's financial operations. I am proficient in various accounting software and have strong attention to detail.\n\nSincerely,\n[Applicant Name]",
                'status' => 'hired',
                'resume_path' => 'resumes/accountant_cv.pdf',
            ],
            [
                'cover_letter' => "Dear Marketing Team,\n\nI am a recent Marketing graduate interested in the Marketing Assistant position. I have experience managing social media accounts for local businesses and creating promotional content. I am creative, enthusiastic, and eager to promote Catanduanes tourism.\n\nBest regards,\n[Applicant Name]",
                'status' => 'rejected',
                'resume_path' => 'resumes/marketing_cv.pdf',
            ],
            [
                'cover_letter' => "Dear Hiring Manager,\n\nAs a web developer with expertise in Laravel and modern frontend technologies, I am applying for the Web Developer position. I have built several websites for local businesses and understand the unique needs of Catanduanes enterprises. I am confident I can deliver high-quality web solutions.\n\nRegards,\n[Applicant Name]",
                'status' => 'pending',
                'resume_path' => 'resumes/web_dev_cv.pdf',
            ],
            [
                'cover_letter' => "Dear School Principal,\n\nI am applying for the Elementary School Teacher position. I have a Bachelor's in Elementary Education and LET license. During my practice teaching, I developed innovative teaching methods that engage young learners. I am dedicated to creating a positive learning environment.\n\nSincerely,\n[Applicant Name]",
                'status' => 'reviewed',
                'resume_path' => 'resumes/elementary_teacher_cv.pdf',
            ],
            [
                'cover_letter' => "Dear Store Manager,\n\nI am applying for the Sales Associate position. I have excellent customer service skills and enjoy helping customers find what they need. I am reliable, hardworking, and eager to contribute to your hardware store's success.\n\nBest regards,\n[Applicant Name]",
                'status' => 'shortlisted',
                'resume_path' => 'resumes/sales_cv.pdf',
            ],
            [
                'cover_letter' => "Dear Engineering Department,\n\nAs a licensed Civil Engineer with 5 years of construction experience, I am applying for the Civil Engineer position. I have managed several projects in Catanduanes and am familiar with local building codes and regulations. I am committed to delivering quality construction projects.\n\nRespectfully,\n[Applicant Name]",
                'status' => 'pending',
                'resume_path' => 'resumes/civil_engineer_cv.pdf',
            ],
            [
                'cover_letter' => "Dear Agriculture Office,\n\nI am applying for the Agricultural Technician position. With my degree in Agriculture and experience in modern farming techniques, I can help local farmers improve their yields. I am passionate about sustainable agriculture and community development.\n\nSincerely,\n[Applicant Name]",
                'status' => 'reviewed',
                'resume_path' => 'resumes/agriculture_cv.pdf',
            ],
        ];

        $statuses = ['pending', 'reviewed', 'shortlisted', 'rejected', 'hired'];

        // Create applications for various job postings
        foreach ($jobPostings->take(10) as $index => $job) {
            // Each job gets 1-3 applications
            $numApplications = rand(1, 3);

            for ($i = 0; $i < $numApplications; $i++) {
                $jobSeeker = $jobSeekers->random();

                // Check if this job seeker already applied for this job
                $existingApplication = JobApplication::where('job_posting_id', $job->id)
                    ->where('job_seeker_id', $jobSeeker->id)
                    ->first();

                if ($existingApplication) {
                    continue;
                }

                // Use predefined application data if available, otherwise generate random
                $appData = isset($applicationData[$index]) ? $applicationData[$index] : [
                    'cover_letter' => $this->generateCoverLetter($job->job_title, $job->employer->company_name ?? ''),
                    'status' => $statuses[array_rand($statuses)],
                    'resume_path' => 'resumes/sample_cv_' . rand(1, 5) . '.pdf',
                ];

                JobApplication::create([
                    'job_posting_id' => $job->id,
                    'job_seeker_id' => $jobSeeker->id,
                    'cover_letter' => $appData['cover_letter'],
                    'resume_path' => $appData['resume_path'],
                    'status' => $appData['status'],
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 15)),
                ]);
            }
        }

        $this->command->info('✅ Job applications seeded successfully!');
    }

    private function generateCoverLetter($jobTitle, $companyName): string
    {
        $templates = [
            "Dear Hiring Manager,\n\nI am writing to express my interest in the {$jobTitle} position at {$companyName}. With my qualifications and experience, I believe I would be a valuable addition to your team.\n\nThank you for considering my application.\n\nSincerely,\n[Applicant Name]",

            "To the Hiring Committee,\n\nI am excited to apply for the {$jobTitle} position. I have been following {$companyName}'s work and am impressed by your contributions to our community. I am confident that my skills align well with your requirements.\n\nBest regards,\n[Applicant Name]",

            "Dear {$companyName} Team,\n\nI am applying for the {$jobTitle} position advertised on your portal. As a CatSU graduate, I am eager to contribute to local development and believe this position is an excellent opportunity to do so.\n\nRespectfully,\n[Applicant Name]",
        ];

        return $templates[array_rand($templates)];
    }
}
