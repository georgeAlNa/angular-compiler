<?php

namespace App\Traits;

trait HasEnums
{
    /**
     * Get validation rules for enum fields
     */
    public static function getEnumValidationRule(string $enumClass): string
    {
        if (!enum_exists($enumClass)) {
            throw new \InvalidArgumentException("Class {$enumClass} is not a valid enum");
        }

        $values = $enumClass::values();
        return 'required|string|in:' . implode(',', $values);
    }

    /**
     * Get validation rules for optional enum fields
     */
    public static function getOptionalEnumValidationRule(string $enumClass): string
    {
        if (!enum_exists($enumClass)) {
            throw new \InvalidArgumentException("Class {$enumClass} is not a valid enum");
        }

        $values = $enumClass::values();
        return 'nullable|string|in:' . implode(',', $values);
    }

    /**
     * Cast attribute to enum
     */
    protected function castToEnum(string $attribute, string $enumClass)
    {
        $value = $this->attributes[$attribute] ?? null;

        if ($value === null) {
            return null;
        }

        if (!enum_exists($enumClass)) {
            throw new \InvalidArgumentException("Class {$enumClass} is not a valid enum");
        }

        return $enumClass::from($value);
    }

    /**
     * Set enum attribute
     */
    protected function setEnumAttribute(string $attribute, $value, string $enumClass): void
    {
        if ($value === null) {
            $this->attributes[$attribute] = null;
            return;
        }

        if ($value instanceof $enumClass) {
            $this->attributes[$attribute] = $value->value;
            return;
        }

        if (is_string($value) && $enumClass::isValid($value)) {
            $this->attributes[$attribute] = $value;
            return;
        }

        throw new \InvalidArgumentException("Invalid value for {$attribute}: {$value}");
    }

    /**
     * Scope query by enum value
     */
    public function scopeWhereEnum($query, string $column, $enumValue)
    {
        if ($enumValue instanceof \BackedEnum) {
            return $query->where($column, $enumValue->value);
        }

        return $query->where($column, $enumValue);
    }

    /**
     * Scope query by multiple enum values
     */
    public function scopeWhereEnumIn($query, string $column, array $enumValues)
    {
        $values = array_map(function ($value) {
            return $value instanceof \BackedEnum ? $value->value : $value;
        }, $enumValues);

        return $query->whereIn($column, $values);
    }


}
