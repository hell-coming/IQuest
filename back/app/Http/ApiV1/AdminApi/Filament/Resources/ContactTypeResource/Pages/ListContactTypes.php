<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ContactTypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ContactTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactTypes extends ListRecords
{
    protected static string $resource = ContactTypeResource::class;

    protected ?string $heading = 'Типы контактов';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalHeading('Создание типа контакта')
                ->createAnother(false),
        ];
    }
}
