<?php

namespace App\Domain\Users\Enums;

use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasLabel
{
    case ADMIN = 'Админ';
    case OPERATOR = 'Оператор';
    case FILIAL_ADMIN = 'Админ филиала';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
