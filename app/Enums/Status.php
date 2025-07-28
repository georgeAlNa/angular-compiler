<?php

namespace App\Enums;

enum Status: string
{
    case DRAFT = 'draft';
    case PENDING_ADMIN_APPROVAL = 'pending admin approval';
    case REJECTED_BY_ADMIN = 'rejected by admin';
    case PRICED_BY_ADMIN = 'priced by admin';
    case PENDING_CUSTOMER_APPROVAL = 'pending customer approval';
    case REJECTED_BY_CUSTOMER = 'rejected by customer';
    case PAID = 'paid';
    case IN_TRANSIT = 'in transit';
    case DELIVERED = 'delivered';
    case PENDING_FOR_ASSIGNMENT = 'pending for assignment';
    case DELIVERED_TO_DESTINATION_CENTER = 'delivered to destination center';

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
