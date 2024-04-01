<?php

namespace App\Http\ApiV1\FrontApi\Modules\Sales\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Sales\Queries\SalesQuery;
use App\Http\ApiV1\FrontApi\Modules\Sales\Resources\SalesResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SalesController
{
    public function get(int $id, SalesQuery $query): SalesResource
    {
        return new SalesResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, SalesQuery $query): AnonymousResourceCollection
    {
        return SalesResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
