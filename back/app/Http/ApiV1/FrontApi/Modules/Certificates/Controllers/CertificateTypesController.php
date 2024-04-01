<?php

namespace App\Http\ApiV1\FrontApi\Modules\Certificates\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Certificates\Queries\CertificateTypesQuery;
use App\Http\ApiV1\FrontApi\Modules\Certificates\Resources\CertificateTypesResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CertificateTypesController
{
    public function get(int $id, CertificateTypesQuery $query): CertificateTypesResource
    {
        return new CertificateTypesResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, CertificateTypesQuery $query): AnonymousResourceCollection
    {
        return CertificateTypesResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
