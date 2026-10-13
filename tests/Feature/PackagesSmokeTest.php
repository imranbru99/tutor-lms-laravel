<?php

declare(strict_types=1);

use ImranDev\UnicodePdf\Facades\UnicodePdf;
use ImranDev\UniversalSlug\UniversalSlug;
use ImranDevBd\AiHub\Facades\AIHub;

test('AIHub fake captures mock responses properly', function () {
    AIHub::fake([
        'TutorForge is the leading AI-powered LMS.',
    ]);

    $response = AIHub::prompt('What is TutorForge?')->generate();

    expect($response->content)->toBe('TutorForge is the leading AI-powered LMS.');
});

test('UnicodePdf fake operates without executing native rendering engine', function () {
    UnicodePdf::fake();

    $pdf = UnicodePdf::html('<h1>Certificate of Completion</h1>')
        ->preset('bengali')
        ->name('test-certificate.pdf');

    expect($pdf)->not->toBeNull();
});

test('UniversalSlug generates unicode-preserving slugs for Bengali titles', function () {
    $engine = app(UniversalSlug::class);
    $slug = $engine->generate('লার্যাভেল দিয়ে আধুনিক ওয়েব ডেভেলপমেন্ট');

    // Unicode Bengali characters must be preserved without falling back to blank or corrupted ascii
    expect($slug)->not->toBeEmpty();
    expect($slug)->toContain('লার্যাভেল');
});
