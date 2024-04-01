<?php

namespace App\Domain\Holidays\Enums;

use Filament\Support\Contracts\HasLabel;

enum HolidayType: string implements HasLabel
{
    case ADULT = 'Взрослый праздник';
    case CHILDREN = 'Детский праздник';
    case CORPORATE = 'Корпоратив';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
