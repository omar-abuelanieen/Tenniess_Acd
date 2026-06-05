<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidPlayerAge implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value <5){
            $fail('The :attribute must be at least 5 years old.');
        } elseif ($value > 40) {
            $fail('The :attribute may not be greater than 40 years old.');
        }
    }
}
