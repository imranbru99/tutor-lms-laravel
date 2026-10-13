<?php

declare(strict_types=1);

namespace App\Casts;

use App\ValueObjects\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * @implements CastsAttributes<Money, Money|int>
 */
class MoneyCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Money
    {
        if ($value === null) {
            return null;
        }

        $currencyKey = $key.'_currency';
        $currency = $attributes[$currencyKey] ?? ($attributes['currency'] ?? 'BDT');

        return Money::fromMinor((int) $value, (string) $currency);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value === null) {
            return [$key => null];
        }

        if ($value instanceof Money) {
            $currencyKey = $key.'_currency';

            if (array_key_exists($currencyKey, $attributes)) {
                return [
                    $key => $value->amount,
                    $currencyKey => $value->currency,
                ];
            }

            return [$key => $value->amount];
        }

        if (is_int($value)) {
            return [$key => $value];
        }

        throw new InvalidArgumentException("Expected Money or int for {$key}");
    }
}
