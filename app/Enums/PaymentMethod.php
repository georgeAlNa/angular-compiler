<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case SYRIATEL_CASH = 'Syriatel_Cash';
    case MTN_CASH = 'MTN_Cash';

    /**
     * Get all enum values as an array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all enum names as an array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Get enum cases as key-value pairs
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->name;
        }
        return $options;
    }

    /**
     * Check if a value exists in the enum
     */
    public static function isValid(string $value): bool
    {
        return in_array($value, self::values());
    }


}
