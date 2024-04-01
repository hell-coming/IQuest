<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages;

use App\Domain\Lounges\Models\Lounge;
use App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource;
use Filament\Resources\Pages\ViewRecord;

class ViewLounge extends ViewRecord
{
    protected static string $resource = LoungeResource::class;

    protected ?string $heading = 'Просмотр лаунжа';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $lounge = Lounge::query()->with(['filial', 'filial.city'])->find($data['id']);

        $data['city'] = $lounge?->filial->city->id;

        return $data;
    }
}
