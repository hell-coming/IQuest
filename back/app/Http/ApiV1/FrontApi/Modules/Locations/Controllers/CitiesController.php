<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Locations\Queries\CitiesQuery;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\CitiesResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CitiesController
{
    public function get(int $id, CitiesQuery $query): CitiesResource
    {
        return new CitiesResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, CitiesQuery $query): AnonymousResourceCollection
    {
        return CitiesResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
