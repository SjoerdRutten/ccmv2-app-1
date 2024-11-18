<?php

namespace Sellvation\CCMV2\CrmCards\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class PatternRule implements ValidationRule
{
    public function __construct(private readonly string $comparison, private readonly mixed $checkValue) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = false;
        switch ($this->comparison) {
            case 'alphaSpace':
                $pattern = '^[\p{L}\s\-,\'"\.]+$';
                break;
            case 'alphaNoSpace':
                $pattern = '^[\p{L}]+$';
                break;
            case 'alphaNumericSpace':
                $pattern = '^[\p{L}0-9\s\-,\'"\.]+$';
                break;
            case 'alphaNumericNoSpace':
                $pattern = '^[\p{L}0-9]+$';
                break;
            case 'dateTime':
                $pattern = '^[0-9]{4}-[01][0-9]-[0123][0-9] ([012][0-9]:[012345][0-9]:[012345][0-9])?$';
                break;
            case 'number':
                $pattern = '^[-+]?\d*(?:[,.]\d+)?(?<=\d)$';
                break;
            case 'initials':
                $pattern = '^[\p{L}]+[\p{L}\s.-]*$';
                break;
            case 'numericSpaces':
                $pattern = '^[0-9\s\-,\'"\.]+$';
                break;
            case 'numericNoSpaces':
                $pattern = '^[0-9]+$';
                break;
            case 'personName':
                $pattern = '^(?=.*\p{L})[\p{L}\s\-,\'"\.\\/\\\\]+$';
                break;
            case 'cityName':
            case 'streetName':
                $pattern = '^(?=.*\p{L})[\p{L}\s\d\-,\'"\.\\/\\\\]+$';
                break;
            case 'telephone':
                $pattern = '^(?=(?:[^#,*]*\d){6,})(?:\+\d{0,4})?(?:\s?\(\d+\))?(?:[\s-]?\d+)+(?:[#*]\d+|(?:,*\d*)*)?$';
                break;
        }

        if ($pattern) {
            if (@preg_match('/'.$pattern.'/ui', trim(Str::lower($value))) !== 1) {
                $fail('Dit is geen geldige waarde voor')->translate([
                    'value' => $this->comparison,
                ]);
            }
        }
    }
}
