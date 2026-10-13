<?php

declare(strict_types=1);

use ImranDevBD\LaravelAdminPanel\Facades\AdminPanel;

test('three distinct admin panels are registered in the panel registry', function () {
    $panels = AdminPanel::getPanels();

    expect($panels)->toHaveKeys(['admin', 'instructor', 'org']);
    expect($panels['admin']->getPath())->toBe('admin');
    expect($panels['instructor']->getPath())->toBe('instructor');
    expect($panels['org']->getPath())->toBe('org');
});

test('admin dashboard routes return success status for all panels', function () {
    $this->get('/admin')->assertSuccessful();
    $this->get('/instructor')->assertSuccessful();
    $this->get('/org')->assertSuccessful();
});
