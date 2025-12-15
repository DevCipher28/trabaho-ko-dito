<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@catsu.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '09123456789',
            'address' => 'CatSU Main Campus, Virac, Catanduanes',
            'email_verified_at' => now(),
        ]);

        // Create some employers
        $employers = [
            [
                'name' => 'Juan Dela Cruz',
                'email' => 'employer1@example.com',
                'password' => Hash::make('password'),
                'role' => 'employer',
                'phone' => '09123456790',
                'company_name' => 'Catanduanes National High School',
                'address' => 'Virac, Catanduanes',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'employer2@example.com',
                'password' => Hash::make('password'),
                'role' => 'employer',
                'phone' => '09123456791',
                'company_name' => 'Eastern Bicol Medical Center',
                'address' => 'Virac, Catanduanes',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Pedro Gomez',
                'email' => 'employer3@example.com',
                'password' => Hash::make('password'),
                'role' => 'employer',
                'phone' => '09123456792',
                'company_name' => 'Local Government Unit',
                'address' => 'San Andres, Catanduanes',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($employers as $employer) {
            User::create($employer);
        }

        // Create some job seekers
        $jobSeekers = [
            [
                'name' => 'Ana Reyes',
                'email' => 'jobseeker1@example.com',
                'password' => Hash::make('password'),
                'role' => 'job_seeker',
                'phone' => '09123456793',
                'address' => 'Virac, Catanduanes',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Luis Torres',
                'email' => 'jobseeker2@example.com',
                'password' => Hash::make('password'),
                'role' => 'job_seeker',
                'phone' => '09123456794',
                'address' => 'Bato, Catanduanes',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($jobSeekers as $seeker) {
            User::create($seeker);
        }

        // Create more random users
        User::factory()->count(10)->create([
            'role' => 'job_seeker'
        ]);

        $this->command->info('✅ Users seeded successfully!');
    }
}
