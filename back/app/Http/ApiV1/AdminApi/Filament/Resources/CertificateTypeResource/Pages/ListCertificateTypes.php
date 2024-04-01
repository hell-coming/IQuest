<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\CertificateTypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\CertificateTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCertificateTypes extends ListRecords
{
    protected static string $resource = CertificateTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
