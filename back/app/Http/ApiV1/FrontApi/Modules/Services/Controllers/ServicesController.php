<?php

namespace App\Http\ApiV1\FrontApi\Modules\Services\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Services\Queries\ServicesQuery;
use App\Http\ApiV1\FrontApi\Modules\Services\Resources\ServicesResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ServicesController
{
    public function get(int $id, ServicesQuery $query): ServicesResource
    {
        return new ServicesResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, ServicesQuery $query): AnonymousResourceCollection
    {
        return ServicesResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
