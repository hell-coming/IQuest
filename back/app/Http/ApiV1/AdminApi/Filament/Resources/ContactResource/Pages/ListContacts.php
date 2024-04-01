<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ContactResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalHeading('Создание контакта')
                ->createAnother(false),
        ];
    }
}
