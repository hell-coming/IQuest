<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\Pages;

use App\Domain\Lounges\Models\Lounge;
use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource;

class EditScheduleLounge extends BaseEditRecord
{
    protected static string $resource = ScheduleLoungeResource::class;

    protected ?string $heading = 'Редактирование слота';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $lounge = Lounge::query()->with(['filial', 'filial.city'])->find($data['lounge_id']);

        $data['filial'] = $lounge?->filial->id;
        $data['city'] = $lounge?->filial->city->id;

        return $data;
    }
}
