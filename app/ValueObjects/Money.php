<?php

declare(strict_types=1);

namespace App\ValueObjects;

use ImranDev\UnicodePdf\Facades\UnicodePdf;
use InvalidArgumentException;
use JsonSerializable;
use Stringable;

final class Money implements JsonSerializable, Stringable
{
    public function __construct(
        public readonly int $amount,
        public readonly string $currency = 'BDT'
    ) {
        if (strlen($this->currency) !== 3) {
            throw new InvalidArgumentException("Currency must be a 3-letter ISO code: {$this->currency}");
        }
    }

    public static function fromMinor(int $amount, string $currency = 'BDT'): self
    {
        return new self($amount, strtoupper($currency));
    }

    public static function fromMajor(float|int $amount, string $currency = 'BDT'): self
    {
        return new self((int) round($amount * 100), strtoupper($currency));
    }

    public static function zero(string $currency = 'BDT'): self
    {
        return new self(0, strtoupper($currency));
    }

    public function toMajor(): float
    {
        return $this->amount / 100;
    }

    public function add(Money $other): self
    {
        $this->assertSameCurrency($other);

        return new self($this->amount + $other->amount, $this->currency);
    }

    public function subtract(Money $other): self
    {
        $this->assertSameCurrency($other);

        return new self($this->amount - $other->amount, $this->currency);
    }

    public function multiply(float $factor): self
    {
        return new self((int) round($this->amount * $factor), $this->currency);
    }

    public function percentage(float $percent): self
    {
        return $this->multiply($percent / 100);
    }

    public function isZero(): bool
    {
        return $this->amount === 0;
    }

    public function isPositive(): bool
    {
        return $this->amount > 0;
    }

    public function isNegative(): bool
    {
        return $this->amount < 0;
    }

    /**
     * Formats the monetary amount with symbol and optional Bengali numerals.
     */
    public function format(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $major = number_format($this->toMajor(), 2, '.', ',');

        $symbols = [
            'BDT' => '৳',
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
        ];

        $symbol = $symbols[$this->currency] ?? ($this->currency.' ');

        if ($locale === 'bn') {
            // Convert digits to Bengali numerals
            $converted = UnicodePdf::numerals($major, 'bn');

            return $symbol.$converted;
        }

        return $symbol.$major;
    }

    private function assertSameCurrency(Money $other): void
    {
        if ($this->currency !== $other->currency) {
            throw new InvalidArgumentException("Cannot operate on different currencies: {$this->currency} and {$other->currency}");
        }
    }

    /**
     * @return array{amount: int, currency: string, formatted: string}
     */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'formatted' => $this->format(),
        ];
    }

    public function __toString(): string
    {
        return $this->format();
    }
}
