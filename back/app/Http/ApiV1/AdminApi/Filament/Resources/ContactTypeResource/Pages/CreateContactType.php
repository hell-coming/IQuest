<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ContactTypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ContactTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContactType extends CreateRecord
{
    protected static string $resource = ContactTypeResource::class;

    protected ?string $heading = 'Создание типа контакта';
}
