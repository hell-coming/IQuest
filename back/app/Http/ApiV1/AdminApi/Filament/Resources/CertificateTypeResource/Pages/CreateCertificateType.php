<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\CertificateTypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\CertificateTypeResource;

class CreateCertificateType extends BaseCreateRecord
{
    protected static string $resource = CertificateTypeResource::class;

    protected ?string $heading = 'Создание сертификата';
}
