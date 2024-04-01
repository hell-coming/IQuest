<?php

namespace App\Domain\Quests\Enums;

use Filament\Support\Contracts\HasLabel;

enum LevelEnum: int implements HasLabel
{
    case EASY = 1;
    case MEDIUM = 2;
    case HARD = 3;

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
