<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages;

use App\Domain\Locations\Models\Filial;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource;
use Filament\Resources\Pages\ViewRecord;

class ViewQuest extends ViewRecord
{
    protected static string $resource = QuestResource::class;

    protected ?string $heading = 'Просмотр квеста';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $filial = Filial::query()->with(['city'])->find($data['filial_id']);

        $data['filial'] = $filial->id;
        $data['city'] = $filial->city->id;

        return $data;
    }
}
