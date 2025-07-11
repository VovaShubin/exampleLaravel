<?php

namespace App\Core\Parents\Rules;

use Closure;

/**
 * This rule is created to add support of dot key names
 * (because laravel's 'in' rule doesn't work properly for dot names)
 */
class ArrayKeysValidationRule implements ValidationRule
{
    public function __construct(
        protected readonly array $availableArrayKeys,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach (array_keys($value) as $validatedKey) {
            if (!in_array($validatedKey, $this->availableArrayKeys)) {
                $fail("The key $validatedKey is unsupported for :attribute");
            }}
    }
}
