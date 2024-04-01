<?php

namespace App\Http\ApiV1\AdminApi\Filament\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class LatinRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[a-zA-Z\. \-_@!#$%^&*(){}?><,;:\'"\/\\\|`~]+$/', $value)) {
            $fail('Поле ":attribute" должно содержать только латиницу и спец. символы.');
        }
    }
}
