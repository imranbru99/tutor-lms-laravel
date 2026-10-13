<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

test('user model automatically generates ULID on creation', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    expect($user->ulid)->not->toBeEmpty();
    expect(strlen($user->ulid))->toBe(26);
});

test('user role enum can verify panel access boundaries', function () {
    $admin = User::factory()->admin()->create();
    $instructor = User::factory()->instructor()->create();
    $learner = User::factory()->create();

    expect($admin->role->canAccessAdminPanel())->toBeTrue();
    expect($instructor->role->canAccessInstructorPanel())->toBeTrue();
    expect($instructor->role->canAccessAdminPanel())->toBeFalse();
    expect($learner->role->canAccessAdminPanel())->toBeFalse();
    expect($learner->role->canAccessInstructorPanel())->toBeFalse();
});

test('user role and wildcard permission checks function correctly', function () {
    $role = Role::create([
        'name' => 'Editor',
        'slug' => 'editor',
    ]);

    $permWildcard = Permission::create([
        'name' => 'Manage Courses',
        'slug' => 'courses.*',
        'group' => 'courses',
    ]);

    $role->permissions()->attach($permWildcard->id);

    $user = User::factory()->create(['role' => UserRole::Admin]);
    $user->roles()->attach($role->id);

    // Matches courses.*
    expect($user->hasPermission('courses.create'))->toBeTrue();
    expect($user->hasPermission('courses.publish'))->toBeTrue();

    // Does not match orders.*
    expect($user->hasPermission('orders.refund'))->toBeFalse();

    // SuperAdmin has universal bypass
    $superAdmin = User::factory()->superAdmin()->create();
    expect($superAdmin->hasPermission('anything.at.all'))->toBeTrue();
});
