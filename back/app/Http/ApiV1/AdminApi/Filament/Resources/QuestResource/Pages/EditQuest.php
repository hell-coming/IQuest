<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages;

use App\Domain\Locations\Models\Filial;
use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource;

class EditQuest extends BaseEditRecord
{
    protected static string $resource = QuestResource::class;

    protected ?string $heading = 'Редактирование квеста';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $filial = Filial::find($data['filial_id'])->load('city');
        $data['city'] = $filial?->city->id ?? null;
        return $data;
    }
}
