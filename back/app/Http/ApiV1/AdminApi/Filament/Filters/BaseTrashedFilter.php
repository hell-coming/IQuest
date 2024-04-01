<?php

namespace App\Http\ApiV1\AdminApi\Filament\Filters;

use Filament\Tables\Filters\TrashedFilter;

class BaseTrashedFilter extends TrashedFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->placeholder('Без удаленных');
        $this->trueLabel('С удаленными');
        $this->falseLabel('Без удаленных');
    }
}
