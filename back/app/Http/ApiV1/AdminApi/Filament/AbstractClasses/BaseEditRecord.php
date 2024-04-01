<?php

namespace App\Http\ApiV1\AdminApi\Filament\AbstractClasses;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

abstract class BaseEditRecord extends EditRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->url(static::getResource()::getUrl());
    }
}
