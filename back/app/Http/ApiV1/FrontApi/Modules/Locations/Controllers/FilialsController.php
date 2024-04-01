<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Locations\Queries\FilialsQuery;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\FilialsResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FilialsController
{
    public function get(int $id, FilialsQuery $query): FilialsResource
    {
        return new FilialsResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, FilialsQuery $query): AnonymousResourceCollection
    {
        return FilialsResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
