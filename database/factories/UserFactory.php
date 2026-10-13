<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'ulid' => (string) Str::ulid(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => UserRole::Learner,
            'locale' => 'en',
            'timezone' => 'UTC',
            'avatar' => null,
            'bio' => fake()->sentence(),
            'socials' => ['twitter' => '@tutorforge', 'github' => 'tutorforge'],
            'kids_mode' => false,
            'is_active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::SuperAdmin,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Admin,
        ]);
    }

    public function instructor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Instructor,
        ]);
    }

    public function orgManager(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::OrgManager,
        ]);
    }

    public function bengali(): static
    {
        return $this->state(fn (array $attributes) => [
            'locale' => 'bn',
            'timezone' => 'Asia/Dhaka',
        ]);
    }
}
