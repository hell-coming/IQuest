<?php

namespace App\Http\ApiV1\AdminApi\Filament\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class NameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match("/^[a-zA-ZА-яёЁ'\- ]+$/u", trim($value))) {
            $fail('Поле ":attribute" должно содержать только кириллицу и/или латиницу, апостроф, дефис и пробел.');
        }
    }
}
