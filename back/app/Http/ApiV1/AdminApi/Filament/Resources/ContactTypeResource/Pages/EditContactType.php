<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ContactTypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ContactTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactType extends EditRecord
{
    protected static string $resource = ContactTypeResource::class;

    protected ?string $heading = 'Редактирование типа контакта';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
