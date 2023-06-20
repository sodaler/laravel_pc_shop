<?php

namespace App\Support\Casts;

use App\Support\ValueObjects\Price;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PriceCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): Price
    {
        return Price::make($value);
    }

    public function set($model, string $key, $value, array $attributes): mixed
    {
        if (!$value instanceof Price) {
            $value = Price::make($value);
        }

        return $value->raw();
    }
}
