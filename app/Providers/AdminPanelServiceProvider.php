<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ImranDevBD\LaravelAdminPanel\Facades\AdminPanel;
use ImranDevBD\LaravelAdminPanel\Panel\Panel;

class AdminPanelServiceProvider extends ServiceProvider
{
    /**
     * Register any admin panels and service bindings.
     */
    public function register(): void
    {
        // 1. Admin Panel (/admin) - Full Platform Control
        AdminPanel::registerPanel(
            Panel::make('admin')
                ->path('admin')
                ->guard('web')
                ->middleware(['web'])
                ->theme('indigo')
                ->brandName('TutorForge Admin')
                ->default(true)
        );

        // 2. Instructor Panel (/instructor) - Scoped to instructor courses, students, earnings
        AdminPanel::registerPanel(
            Panel::make('instructor')
                ->path('instructor')
                ->guard('web')
                ->middleware(['web'])
                ->theme('emerald')
                ->brandName('TutorForge Instructor')
        );

        // 3. Organization Panel (/org) - B2B seats, cohorts, group enrollments
        AdminPanel::registerPanel(
            Panel::make('org')
                ->path('org')
                ->guard('web')
                ->middleware(['web'])
                ->theme('blue')
                ->brandName('TutorForge Organization')
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Panel boot hooks & navigation setup
    }
}
