<?php

namespace Sellvation\CCMV2\CrmCards\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class StringComparisonRule implements ValidationRule
{
    public function __construct(private readonly string $comparison, private readonly mixed $checkValue) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        switch ($this->comparison) {
            case 'con':
                $this->contains($value, $fail);
                break;
            case 'dncon':
                $this->doesNotContain($value, $fail);
                break;
            case 'sw':
                $this->startsWith($value, $fail);
                break;
            case 'dnsw':
                $this->doesNotStartWith($value, $fail);
                break;
            case 'ew':
                $this->endsWith($value, $fail);
                break;
            case 'dnew':
                $this->doesNotEndWith($value, $fail);
                break;
            case 'eq':
                $this->equal($value, $fail);
                break;
            case 'neq':
                $this->notEqual($value, $fail);
                break;

        }
    }

    private function contains(mixed $value, Closure $fail)
    {
        if (! Str::contains($value, $this->checkValue)) {
            $fail('Waarde moet :value bevatten')->translate([
                'value' => $this->checkValue,
            ]);
        }
    }

    private function doesNotContain(mixed $value, Closure $fail)
    {
        if (Str::contains($value, $this->checkValue)) {
            $fail('Waarde mag :value niet bevatten')->translate([
                'value' => $this->checkValue,
            ]);
        }
    }

    private function startsWith(mixed $value, Closure $fail)
    {
        if (Str::startsWith($value, $this->checkValue)) {
            $fail('Waarde moet met :value beginnen')->translate([
                'value' => $this->checkValue,
            ]);
        }
    }

    private function doesNotStartWith(mixed $value, Closure $fail)
    {
        if (! Str::startsWith($value, $this->checkValue)) {
            $fail('Waarde mag niet met :value beginnen')->translate([
                'value' => $this->checkValue,
            ]);
        }
    }

    private function endsWith(mixed $value, Closure $fail)
    {
        if (Str::endsWith($value, $this->checkValue)) {
            $fail('Waarde moet met :value eindigen')->translate([
                'value' => $this->checkValue,
            ]);
        }
    }

    private function doesNotEndWith(mixed $value, Closure $fail)
    {
        if (! Str::endsWith($value, $this->checkValue)) {
            $fail('Waarde mag niet net :value eindigen')->translate([
                'value' => $this->checkValue,
            ]);
        }
    }

    private function equal(mixed $value, Closure $fail)
    {
        if ($value !== $this->checkValue) {
            $fail('Waarde moet overeenkomen met :value')->translate([
                'value' => $this->checkValue,
            ]);
        }
    }

    private function notEqual(mixed $value, Closure $fail)
    {
        if ($value !== $this->checkValue) {
            $fail('Waarde mag niet overeenkomen met :value')->translate([
                'value' => $this->checkValue,
            ]);
        }
    }
}
