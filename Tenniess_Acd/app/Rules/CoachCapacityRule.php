<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CoachCapacityRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value > 20) {
            $fail('The :attribute may not have more than 20 players assigned.');

        }
        elseif ($value < 10) {
            $fail('The :attribute must have at least 10 players assigned.');
        }
    }
}
