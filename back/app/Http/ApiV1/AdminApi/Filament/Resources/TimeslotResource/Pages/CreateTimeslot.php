<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTimeslot extends CreateRecord
{
    protected static string $resource = TimeslotResource::class;
}
