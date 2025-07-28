<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnumRule implements ValidationRule
{
    protected string $enumClass;
    protected bool $nullable;

    public function __construct(string $enumClass, bool $nullable = false)
    {
        if (!enum_exists($enumClass)) {
            throw new \InvalidArgumentException("Class {$enumClass} is not a valid enum");
        }

        $this->enumClass = $enumClass;
        $this->nullable = $nullable;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Handle nullable case
        if ($this->nullable && ($value === null || $value === '')) {
            return;
        }

        // Check if value is null when not nullable
        if (!$this->nullable && ($value === null || $value === '')) {
            $fail("The {$attribute} field is required.");
            return;
        }

        // Check if value is valid for the enum
        if (!$this->enumClass::isValid($value)) {
            $validValues = implode(', ', $this->enumClass::values());
            $fail("The {$attribute} field must be one of: {$validValues}.");
        }
    }

    /**
     * Create a nullable enum rule
     */
    public static function nullable(string $enumClass): self
    {
        return new self($enumClass, true);
    }

    /**
     * Create a required enum rule
     */
    public static function required(string $enumClass): self
    {
        return new self($enumClass, false);
    }
}