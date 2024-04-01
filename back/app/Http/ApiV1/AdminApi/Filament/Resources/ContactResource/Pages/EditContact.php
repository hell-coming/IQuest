<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ContactResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
