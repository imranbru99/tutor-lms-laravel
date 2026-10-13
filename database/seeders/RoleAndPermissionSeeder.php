<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Core Roles
        $roles = [
            UserRole::SuperAdmin->value => [
                'name' => 'Super Administrator',
                'description' => 'Unrestricted platform access and governance',
            ],
            UserRole::Admin->value => [
                'name' => 'Platform Administrator',
                'description' => 'Operational control over courses, users, and orders',
            ],
            UserRole::Instructor->value => [
                'name' => 'Course Instructor',
                'description' => 'Author courses, grade assignments, view earnings',
            ],
            UserRole::AssistantInstructor->value => [
                'name' => 'Assistant Instructor',
                'description' => 'Support grading and learner inquiries',
            ],
            UserRole::OrgManager->value => [
                'name' => 'Organization Manager',
                'description' => 'Manage corporate cohorts, learner seats, and reports',
            ],
            UserRole::Support->value => [
                'name' => 'Customer Support',
                'description' => 'Handle support tickets and view customer orders',
            ],
            UserRole::Learner->value => [
                'name' => 'Student Learner',
                'description' => 'Enroll, take lessons, attempt quizzes, earn certificates',
            ],
        ];

        $createdRoles = [];
        foreach ($roles as $slug => $data) {
            $createdRoles[$slug] = Role::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'is_system' => true,
                ]
            );
        }

        // 2. Core Permissions
        $permissions = [
            'courses.*' => ['name' => 'Manage All Courses', 'group' => 'courses'],
            'courses.create' => ['name' => 'Create Course', 'group' => 'courses'],
            'courses.update' => ['name' => 'Update Course', 'group' => 'courses'],
            'courses.publish' => ['name' => 'Publish Course', 'group' => 'courses'],
            'orders.*' => ['name' => 'Manage Orders', 'group' => 'orders'],
            'orders.refund' => ['name' => 'Issue Order Refund', 'group' => 'orders'],
            'ai.access' => ['name' => 'Access AI Generation Features', 'group' => 'ai'],
            'ai.admin' => ['name' => 'Configure AI Hub Models and Budgets', 'group' => 'ai'],
            'payouts.approve' => ['name' => 'Approve Instructor Payouts', 'group' => 'payouts'],
            'certificates.revoke' => ['name' => 'Revoke Certificates', 'group' => 'certificates'],
        ];

        foreach ($permissions as $slug => $data) {
            $perm = Permission::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'group' => $data['group'],
                ]
            );

            // Assign wildcard permissions to Admin role
            $createdRoles[UserRole::Admin->value]->permissions()->syncWithoutDetaching([$perm->id]);
        }
    }
}
