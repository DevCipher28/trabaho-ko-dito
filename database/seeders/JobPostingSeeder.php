<?php

namespace Database\Seeders;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JobPostingSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create employer users
        $employers = User::where('role', 'employer')->get();

        if ($employers->isEmpty()) {
            // Create some employer users if none exist
            $employers = User::factory()->count(5)->create([
                'role' => 'employer',
                'company_name' => function () {
                    return $this->getCompanies()[array_rand($this->getCompanies())];
                }
            ]);
        }

        $jobData = [
            [
                'job_title' => 'High School Teacher - Mathematics',
                'job_description' => 'We are seeking a passionate and dedicated Mathematics Teacher to join our faculty. The ideal candidate will have a strong background in mathematics and a commitment to student success. Responsibilities include lesson planning, classroom instruction, student assessment, and participation in school activities.',
                'qualifications' => "• Bachelor's Degree in Mathematics Education or related field\n• LET License required\n• At least 2 years teaching experience preferred\n• Strong communication and classroom management skills\n• Proficient in using educational technology",
                'location' => 'Virac, Catanduanes',
                'job_type' => 'full-time',
                'salary_min' => 25000,
                'salary_max' => 32000,
                'industry' => 'Education',
                'application_email' => 'hr@catanduanesnhs.edu.ph',
                'application_phone' => '09123456789',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(30),
            ],
            [
                'job_title' => 'IT Support Specialist',
                'job_description' => 'Provide technical support for university systems, network infrastructure, and end-user devices. Troubleshoot hardware and software issues, maintain computer systems, and assist faculty and staff with technology needs.',
                'qualifications' => "• Bachelor's Degree in Computer Science, IT, or related field\n• 1-2 years experience in IT support\n• Knowledge of Windows/Linux systems\n• Networking fundamentals\n• Good problem-solving skills\n• Customer service oriented",
                'location' => 'Virac, Catanduanes',
                'job_type' => 'full-time',
                'salary_min' => 20000,
                'salary_max' => 28000,
                'industry' => 'Technology',
                'application_email' => 'ict@catsu.edu.ph',
                'application_phone' => '09123456790',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(45),
            ],
            [
                'job_title' => 'Registered Nurse',
                'job_description' => 'Provide comprehensive nursing care to patients, assist physicians with medical procedures, maintain patient records, and ensure adherence to healthcare protocols and standards.',
                'qualifications' => "• Bachelor of Science in Nursing\n• Valid PRC License\n• BLS/ACLS certification preferred\n• At least 1 year hospital experience\n• Good interpersonal skills\n• Willing to work shifts",
                'location' => 'Virac, Catanduanes',
                'job_type' => 'full-time',
                'salary_min' => 23000,
                'salary_max' => 30000,
                'industry' => 'Healthcare',
                'application_email' => 'careers@easternbicolmedical.com',
                'application_phone' => '09123456791',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(25),
            ],
            [
                'job_title' => 'Accountant',
                'job_description' => 'Handle financial records, prepare financial statements, process payroll, manage accounts payable/receivable, and ensure compliance with accounting standards and tax regulations.',
                'qualifications' => "• Bachelor's Degree in Accountancy\n• CPA License required\n• 2-3 years accounting experience\n• Proficient in accounting software\n• Knowledge of BIR regulations\n• Attention to detail",
                'location' => 'San Andres, Catanduanes',
                'job_type' => 'full-time',
                'salary_min' => 22000,
                'salary_max' => 29000,
                'industry' => 'Finance',
                'application_email' => 'accounting@lgu-sanandres.gov.ph',
                'application_phone' => '09123456792',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(35),
            ],
            [
                'job_title' => 'Marketing Assistant',
                'job_description' => 'Assist in developing marketing campaigns, manage social media accounts, create promotional materials, conduct market research, and support tourism promotion activities.',
                'qualifications' => "• Bachelor's Degree in Marketing, Business, or related field\n• Excellent communication skills\n• Social media management experience\n• Creative thinking\n• Photography/video editing skills a plus\n• Fresh graduates welcome",
                'location' => 'Virac, Catanduanes',
                'job_type' => 'part-time',
                'salary_min' => 15000,
                'salary_max' => 20000,
                'industry' => 'Marketing',
                'application_email' => 'tourism@catanduanes.gov.ph',
                'application_phone' => '09123456793',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(20),
            ],
            [
                'job_title' => 'Web Developer',
                'job_description' => 'Design, develop, and maintain websites for local businesses. Work with clients to understand requirements, implement responsive designs, and ensure website functionality and performance.',
                'qualifications' => "• Bachelor's Degree in Computer Science or related field\n• Proficiency in HTML, CSS, JavaScript\n• Experience with PHP/Laravel\n• Knowledge of WordPress\n• Portfolio of previous work\n• Good communication skills",
                'location' => 'Remote',
                'job_type' => 'contract',
                'salary_min' => 30000,
                'salary_max' => 45000,
                'industry' => 'Technology',
                'application_email' => 'jobs@catanduaneswebdev.com',
                'application_phone' => '09123456794',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(40),
            ],
            [
                'job_title' => 'Elementary School Teacher',
                'job_description' => 'Teach elementary level students, develop lesson plans, assess student progress, communicate with parents, and participate in school events and activities.',
                'qualifications' => "• Bachelor's Degree in Elementary Education\n• LET License required\n• Patience and creativity\n• Classroom management skills\n• Willing to handle multiple subjects\n• Fresh graduates may apply",
                'location' => 'Bato, Catanduanes',
                'job_type' => 'full-time',
                'salary_min' => 22000,
                'salary_max' => 28000,
                'industry' => 'Education',
                'application_email' => 'principal@batoelementary.edu.ph',
                'application_phone' => '09123456795',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(30),
            ],
            [
                'job_title' => 'Sales Associate',
                'job_description' => 'Assist customers, manage product displays, process transactions, maintain store cleanliness, and achieve sales targets in a retail environment.',
                'qualifications' => "• High School Diploma or equivalent\n• Good communication skills\n• Customer service experience preferred\n• Basic math skills\n• Pleasant personality\n• Willing to work on weekends",
                'location' => 'Virac, Catanduanes',
                'job_type' => 'part-time',
                'salary_min' => 12000,
                'salary_max' => 18000,
                'industry' => 'Retail',
                'application_email' => 'hr@goldenstarhardware.com',
                'application_phone' => '09123456796',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(15),
            ],
            [
                'job_title' => 'Civil Engineer',
                'job_description' => 'Design, plan, and oversee construction projects. Prepare project specifications, conduct site inspections, ensure compliance with building codes, and manage project budgets.',
                'qualifications' => "• Bachelor's Degree in Civil Engineering\n• Valid PRC License\n• 3+ years experience\n• Knowledge of AutoCAD\n• Project management skills\n• Willing to travel within Catanduanes",
                'location' => 'Virac, Catanduanes',
                'job_type' => 'full-time',
                'salary_min' => 28000,
                'salary_max' => 40000,
                'industry' => 'Construction',
                'application_email' => 'engineering@catanduanesconstruction.com',
                'application_phone' => '09123456797',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(50),
            ],
            [
                'job_title' => 'Agricultural Technician',
                'job_description' => 'Assist farmers with modern farming techniques, conduct soil analysis, demonstrate proper use of agricultural equipment, and provide technical support for crop production.',
                'qualifications' => "• Bachelor's Degree in Agriculture\n• Knowledge of modern farming techniques\n• Experience with agricultural equipment\n• Good physical stamina\n• Communication skills\n• Driver's license",
                'location' => 'Viga, Catanduanes',
                'job_type' => 'full-time',
                'salary_min' => 18000,
                'salary_max' => 25000,
                'industry' => 'Agriculture',
                'application_email' => 'jobs@catanduanesda.gov.ph',
                'application_phone' => '09123456798',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(60),
            ],
            [
                'job_title' => 'Customer Service Representative',
                'job_description' => 'Handle customer inquiries via phone and email, resolve complaints, process orders, maintain customer records, and provide excellent service to clients.',
                'qualifications' => "• College level or graduate\n• Excellent English communication skills\n• Typing speed of at least 40 WPM\n• Problem-solving skills\n• Patient and courteous\n• Willing to work night shifts",
                'location' => 'Virac, Catanduanes',
                'job_type' => 'full-time',
                'salary_min' => 17000,
                'salary_max' => 22000,
                'industry' => 'BPO',
                'application_email' => 'careers@catanduanesbpo.com',
                'application_phone' => '09123456799',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(30),
            ],
            [
                'job_title' => 'Tour Guide',
                'job_description' => 'Lead tour groups to various attractions in Catanduanes, provide information about local history and culture, ensure guest safety, and promote tourism in the province.',
                'qualifications' => "• College degree preferred\n• Excellent communication skills\n• Knowledge of Catanduanes history and culture\n• First Aid certification\n• Pleasant personality\n• Foreign language skill a plus",
                'location' => 'Virac, Catanduanes',
                'job_type' => 'part-time',
                'salary_min' => 15000,
                'salary_max' => 20000,
                'industry' => 'Tourism',
                'application_email' => 'tours@purplebeachresort.com',
                'application_phone' => '09123456800',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(25),
            ],
            [
                'job_title' => 'Graphic Designer',
                'job_description' => 'Create visual content for print and digital media, design marketing materials, develop branding assets, and collaborate with the marketing team on various projects.',
                'qualifications' => "• Bachelor's Degree in Graphic Design or related field\n• Proficiency in Adobe Creative Suite\n• Portfolio of design work\n• Creative thinking\n• Attention to detail\n• Time management skills",
                'location' => 'Remote',
                'job_type' => 'contract',
                'salary_min' => 20000,
                'salary_max' => 35000,
                'industry' => 'Creative',
                'application_email' => 'design@catanduanescreative.com',
                'application_phone' => '09123456801',
                'status' => 'pending',
                'deadline' => Carbon::now()->addDays(30),
            ],
            [
                'job_title' => 'Pharmacist',
                'job_description' => 'Dispense medications, provide drug information to patients and healthcare professionals, manage pharmacy inventory, and ensure compliance with pharmaceutical regulations.',
                'qualifications' => "• Bachelor of Science in Pharmacy\n• Valid PRC License\n• 1-2 years experience preferred\n• Good communication skills\n• Attention to detail\n• Knowledge of drug interactions",
                'location' => 'Virac, Catanduanes',
                'job_type' => 'full-time',
                'salary_min' => 25000,
                'salary_max' => 35000,
                'industry' => 'Healthcare',
                'application_email' => 'hr@mercuryvirac.com',
                'application_phone' => '09123456802',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(20),
            ],
            [
                'job_title' => 'Administrative Assistant',
                'job_description' => 'Provide administrative support to office staff, manage schedules, prepare documents, handle correspondence, and maintain office organization.',
                'qualifications' => "• College degree in Business or related field\n• Proficiency in MS Office\n• Good organizational skills\n• Communication skills\n• Attention to detail\n• Can work with minimal supervision",
                'location' => 'Virac, Catanduanes',
                'job_type' => 'full-time',
                'salary_min' => 16000,
                'salary_max' => 22000,
                'industry' => 'Administration',
                'application_email' => 'admin@catanduaneslgu.gov.ph',
                'application_phone' => '09123456803',
                'status' => 'approved',
                'deadline' => Carbon::now()->addDays(30),
            ],
        ];

        foreach ($jobData as $job) {
            // Assign random employer
            $employer = $employers->random();

            JobPosting::create([
                'employer_id' => $employer->id,
                'job_title' => $job['job_title'],
                'job_description' => $job['job_description'],
                'qualifications' => $job['qualifications'],
                'location' => $job['location'],
                'job_type' => $job['job_type'],
                'salary_min' => $job['salary_min'],
                'salary_max' => $job['salary_max'],
                'industry' => $job['industry'],
                'application_email' => $job['application_email'],
                'application_phone' => $job['application_phone'],
                'status' => $job['status'],
                'deadline' => $job['deadline'],
                'views' => rand(50, 500),
                'created_at' => Carbon::now()->subDays(rand(1, 60)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30)),
            ]);
        }

        $this->command->info('✅ Job postings seeded successfully!');
    }

    private function getCompanies(): array
    {
        return [
            'Catanduanes National High School',
            'CatSU - ICT Department',
            'Eastern Bicol Medical Center',
            'Local Government Unit - San Andres',
            'Catanduanes Tourism Office',
            'Catanduanes Web Development',
            'Bato Elementary School',
            'Golden Star Hardware',
            'Catanduanes Construction Co.',
            'Department of Agriculture - Catanduanes',
            'Catanduanes BPO Solutions',
            'Purple Beach Resort',
            'Catanduanes Creative Studio',
            'Mercury Drug Virac',
            'Provincial Government of Catanduanes',
        ];
    }
}
