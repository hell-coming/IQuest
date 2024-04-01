<?php

namespace App\Http\ApiV1\AdminApi\Filament\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class LatinNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[a-zA-Z0-9\. \-_@!#$%^&*(){}?><,;:\'"\/\\\|`~]+$/iu', $value)) {
            $fail('Поле ":attribute" должно содержать только латиницу, цифры и спец. символы.');
        }
    }
}
