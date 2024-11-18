<?php

namespace Sellvation\CCMV2\CrmCards\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StringLengthComparisonRule implements ValidationRule
{
    public function __construct(private readonly string $comparison, private readonly mixed $checkValue) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        switch ($this->comparison) {
            case 'eq':
                if (\Str::length($value) !== $this->checkValue) {
                    $fail('Waarde moet uit :value karakters bestaan')->translate([
                        'value' => $this->checkValue,
                    ]);
                }
                break;
            case 'neq':
                if (\Str::length($value) !== $this->checkValue) {
                    $fail('Waarde mag niet uit :value karakters bestaan')->translate([
                        'value' => $this->checkValue,
                    ]);
                }
                break;
        }
    }
}
