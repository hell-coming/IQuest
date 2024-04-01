<?php

namespace App\Http\ApiV1\AdminApi\Filament\AbstractClasses;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

abstract class BaseResource extends Resource
{
    public static function canEdit(Model $record): bool
    {
        return !$record->trashed();
    }
}
