<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\InstructorProfile;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Roles & Permissions
        $this->call(RoleAndPermissionSeeder::class);

        // 2. Super Administrator
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@tutorforge.test'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'role' => UserRole::SuperAdmin,
                'locale' => 'en',
                'timezone' => 'UTC',
                'email_verified_at' => now(),
            ]
        );

        // 3. Platform Admin
        User::firstOrCreate(
            ['email' => 'admin@tutorforge.test'],
            [
                'name' => 'Platform Admin',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'locale' => 'en',
                'timezone' => 'UTC',
                'email_verified_at' => now(),
            ]
        );

        // 4. Instructor with InstructorProfile
        $instructor = User::firstOrCreate(
            ['email' => 'instructor@tutorforge.test'],
            [
                'name' => 'Zubair Hossain',
                'password' => Hash::make('password'),
                'role' => UserRole::Instructor,
                'locale' => 'bn',
                'timezone' => 'Asia/Dhaka',
                'bio' => 'Senior Full-Stack Laravel Architect & Tutor',
                'email_verified_at' => now(),
            ]
        );

        InstructorProfile::firstOrCreate(
            ['user_id' => $instructor->id],
            [
                'headline' => 'Master PHP & Laravel Educator',
                'biography' => 'Building modern web applications and training the next generation of engineers.',
                'website' => 'https://tutorforge.test/instructor/zubair',
                'commission_rate' => 15.00,
                'is_verified' => true,
            ]
        );

        // 5. Organization Manager
        $orgManager = User::firstOrCreate(
            ['email' => 'org@tutorforge.test'],
            [
                'name' => 'Dhaka Tech Academy',
                'password' => Hash::make('password'),
                'role' => UserRole::OrgManager,
                'locale' => 'en',
                'timezone' => 'Asia/Dhaka',
                'email_verified_at' => now(),
            ]
        );

        Organization::firstOrCreate(
            ['owner_id' => $orgManager->id],
            [
                'name' => 'Dhaka Tech Academy',
                'slug' => 'dhaka-tech-academy',
                'seat_capacity' => 100,
            ]
        );

        // 6. Demo Learner
        User::firstOrCreate(
            ['email' => 'learner@tutorforge.test'],
            [
                'name' => 'Tanvir Ahmed',
                'password' => Hash::make('password'),
                'role' => UserRole::Learner,
                'locale' => 'bn',
                'timezone' => 'Asia/Dhaka',
                'email_verified_at' => now(),
            ]
        );
    }
}
