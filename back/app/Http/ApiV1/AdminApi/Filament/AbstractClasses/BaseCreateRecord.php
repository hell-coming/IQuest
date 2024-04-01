<?php

namespace App\Http\ApiV1\AdminApi\Filament\AbstractClasses;

use Filament\Resources\Pages\CreateRecord;

abstract class BaseCreateRecord extends CreateRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
