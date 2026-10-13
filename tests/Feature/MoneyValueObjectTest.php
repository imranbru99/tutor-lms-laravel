<?php

declare(strict_types=1);

use App\ValueObjects\Money;

test('money value object stores minor units and converts to major', function () {
    $money = Money::fromMinor(5000, 'BDT');

    expect($money->amount)->toBe(5000);
    expect($money->currency)->toBe('BDT');
    expect($money->toMajor())->toBe(50.0);
});

test('money value object performs addition and percentage operations', function () {
    $a = Money::fromMinor(1000, 'USD');
    $b = Money::fromMinor(2500, 'USD');

    $sum = $a->add($b);
    expect($sum->amount)->toBe(3500);

    $discount = $sum->percentage(20); // 20% of 3500 = 700
    expect($discount->amount)->toBe(700);
});

test('money formats using standard and Bengali numerals', function () {
    $money = Money::fromMinor(150000, 'BDT'); // 1500.00 BDT

    $enFormat = $money->format('en');
    expect($enFormat)->toBe('৳1,500.00');

    $bnFormat = $money->format('bn');
    // Bengali numerals: 1 -> ১, 5 -> ৫, 0 -> ০
    expect($bnFormat)->toContain('৳');
    expect($bnFormat)->toContain('১,৫০০.০০');
});
