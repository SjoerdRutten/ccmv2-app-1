<?php

namespace Sellvation\CCMV2\CrmCards\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NumberComparisonRule implements ValidationRule
{
    public function __construct(private readonly string $comparison, private readonly mixed $checkValue) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        switch ($this->comparison) {
            case 'lt':
                if ($value >= $this->checkValue) {
                    $fail('waarde moet kleiner zijn dan :value')->translate([
                        'value' => $this->checkValue,
                    ]);
                }
                break;
            case 'lte':
                if ($value > $this->checkValue) {
                    $fail('waarde moet kleiner of gelijk zijn aan :value')->translate([
                        'value' => $this->checkValue,
                    ]);
                }
                break;
            case 'gt':
                if ($value <= $this->checkValue) {
                    $fail('waarde moet groter zijn dan :value')->translate([
                        'value' => $this->checkValue,
                    ]);
                }
                break;
            case 'gte':
                if ($value < $this->checkValue) {
                    $fail('waarde moet grote of gelijk zijn aan :value')->translate([
                        'value' => $this->checkValue,
                    ]);
                }
                break;
            case 'eq':
                if ((float) $value !== (float) $this->checkValue) {
                    $fail('waarde moet gelijk zijn aan :value')->translate([
                        'value' => $this->checkValue,
                    ]);
                }
                break;
            case 'neq':
                if ((float) $value === (float) $this->checkValue) {
                    $fail('waarde mag niet gelijk zijn aan :value')->translate([
                        'value' => $this->checkValue,
                    ]);
                }
                break;
        }
    }
}
