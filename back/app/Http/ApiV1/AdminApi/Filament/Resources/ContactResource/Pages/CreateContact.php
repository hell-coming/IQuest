<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ContactResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
