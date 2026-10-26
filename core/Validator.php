<?php

namespace App\Core;

final class Validator
{
    public static function required(string $value): bool
    {
        return trim($value) !== '';
    }

    public static function date(string $value): bool
    {
        return (bool) strtotime($value);
    }

    public static function in(string $value, array $options): bool
    {
        return in_array($value, $options, true);
    }
}
