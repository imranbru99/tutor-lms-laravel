<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super-admin';
    case Admin = 'admin';
    case Instructor = 'instructor';
    case AssistantInstructor = 'assistant-instructor';
    case OrgManager = 'org-manager';
    case Support = 'support';
    case Learner = 'learner';

    /**
     * Human-readable label for UI display.
     */
    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Administrator',
            self::Admin => 'Administrator',
            self::Instructor => 'Instructor',
            self::AssistantInstructor => 'Assistant Instructor',
            self::OrgManager => 'Organization Manager',
            self::Support => 'Support Staff',
            self::Learner => 'Learner',
        };
    }

    /**
     * Determines whether the role has access to the main admin panel (/admin).
     */
    public function canAccessAdminPanel(): bool
    {
        return in_array($this, [self::SuperAdmin, self::Admin, self::Support], true);
    }

    /**
     * Determines whether the role has access to the instructor panel (/instructor).
     */
    public function canAccessInstructorPanel(): bool
    {
        return in_array($this, [self::SuperAdmin, self::Instructor, self::AssistantInstructor], true);
    }

    /**
     * Determines whether the role has access to the organization panel (/org).
     */
    public function canAccessOrgPanel(): bool
    {
        return in_array($this, [self::SuperAdmin, self::OrgManager], true);
    }
}
