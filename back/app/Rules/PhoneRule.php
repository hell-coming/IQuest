<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PhoneRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', $value)) {
            $fail('Телефон должен быть в формате +7 (999) 999-99-99');
        }
    }
}
