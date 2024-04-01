<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages;

use App\Domain\Lounges\Models\Lounge;
use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource;

class EditLounge extends BaseEditRecord
{
    protected static string $resource = LoungeResource::class;

    protected ?string $heading = 'Редактирование лаунжа';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $lounge = Lounge::find($data['id'])->load('filial.city');
        $data['city'] = $lounge->filial->city->id ?? null;
        return $data;
    }
}
