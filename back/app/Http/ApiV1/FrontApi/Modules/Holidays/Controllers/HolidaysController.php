<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Holidays\Queries\HolidaysQuery;
use App\Http\ApiV1\FrontApi\Modules\Holidays\Resources\HolidaysResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HolidaysController
{
    public function get(int $id, HolidaysQuery $query): HolidaysResource
    {
        return new HolidaysResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, HolidaysQuery $query): AnonymousResourceCollection
    {
        return HolidaysResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
