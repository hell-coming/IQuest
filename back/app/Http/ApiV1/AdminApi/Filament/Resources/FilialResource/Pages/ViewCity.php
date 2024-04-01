<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages;

use App\Domain\Locations\Models\Room;
use App\Http\ApiV1\AdminApi\Filament\Resources\CityResource;
use Filament\Resources\Pages\ViewRecord;

class ViewCity extends ViewRecord
{
    protected static string $resource = CityResource::class;

    protected ?string $heading = 'Просмотр квеста';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $room = Room::query()->with(['filial', 'filial.city'])->find($data['room_id']);

        $data['filial'] = $room?->filial->id;
        $data['city'] = $room?->filial->city->id;

        return $data;
    }
}
