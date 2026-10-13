<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $ulid
 * @property UserRole|string $role
 * @property-read Collection<int, Role> $roles
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'ulid',
        'tenant_id',
        'name',
        'email',
        'password',
        'role',
        'locale',
        'timezone',
        'avatar',
        'bio',
        'socials',
        'kids_mode',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Boot model events: generate ULID automatically.
     */
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->ulid)) {
                $user->ulid = (string) Str::ulid();
            }
        });
    }

    /**
     * Attributes cast definitions.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'kids_mode' => 'boolean',
            'is_active' => 'boolean',
            'socials' => 'array',
            'role' => UserRole::class,
        ];
    }

    /**
     * Assigned roles relationship.
     *
     * @return BelongsToMany<Role, $this>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Associated instructor profile.
     *
     * @return HasOne<InstructorProfile, $this>
     */
    public function instructorProfile(): HasOne
    {
        return $this->hasOne(InstructorProfile::class);
    }

    /**
     * Organizations the user belongs to.
     *
     * @return BelongsToMany<Organization, $this>
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Check if user has a specific role or any role in a list.
     *
     * @param  string|UserRole|array<int, string|UserRole>  $roles
     */
    public function hasRole(string|UserRole|array $roles): bool
    {
        $roleValues = is_array($roles)
            ? array_map(fn ($r) => $r instanceof UserRole ? $r->value : (string) $r, $roles)
            : [$roles instanceof UserRole ? $roles->value : (string) $roles];

        $currentRole = $this->role instanceof UserRole ? $this->role->value : (string) $this->role;

        if (in_array($currentRole, $roleValues, true)) {
            return true;
        }

        // Also check role pivot if multiple roles are assigned
        return $this->roles()->whereIn('slug', $roleValues)->exists();
    }

    /**
     * Check permission with wildcard support (e.g. 'courses.*' matches 'courses.create').
     */
    public function hasPermission(string $permission): bool
    {
        // Super-admin has wildcard access to all operations
        if ($this->hasRole(UserRole::SuperAdmin)) {
            return true;
        }

        /** @var Collection<int, Role> $roles */
        $roles = $this->roles()->with('permissions')->get();

        $allPermissionSlugs = [];
        foreach ($roles as $role) {
            foreach ($role->permissions as $perm) {
                $allPermissionSlugs[] = (string) $perm->slug;
            }
        }

        foreach (array_unique($allPermissionSlugs) as $userPerm) {
            if ($userPerm === '*' || $userPerm === $permission) {
                return true;
            }

            if (str_ends_with($userPerm, '.*')) {
                $prefix = substr($userPerm, 0, -2);
                if (str_starts_with($permission, $prefix.'.')) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Determine if user has two-factor authentication enabled.
     */
    public function hasTwoFactorEnabled(): bool
    {
        return ! empty($this->two_factor_secret) && ! empty($this->two_factor_confirmed_at);
    }
}
