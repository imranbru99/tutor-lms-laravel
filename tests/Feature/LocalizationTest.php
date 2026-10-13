<?php

declare(strict_types=1);

test('english and bengali translations load correctly for core LMS strings', function () {
    app()->setLocale('en');
    expect(__('Welcome to TutorForge'))->toBe('Welcome to TutorForge');
    expect(__('Enroll Now'))->toBe('Enroll Now');
    expect(__('My Courses'))->toBe('My Courses');

    app()->setLocale('bn');
    expect(__('Welcome to TutorForge'))->toBe('টিউটরফোজে স্বাগতম');
    expect(__('Enroll Now'))->toBe('এখনই ভর্তি হোন');
    expect(__('My Courses'))->toBe('আমার কোর্সসমূহ');
});
