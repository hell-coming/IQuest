<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Holidays\Queries\HolidayPackagesQuery;
use App\Http\ApiV1\FrontApi\Modules\Holidays\Resources\HolidayPackagesResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HolidayPackagesController
{
    public function get(int $id, HolidayPackagesQuery $query): HolidayPackagesResource
    {
        return new HolidayPackagesResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, HolidayPackagesQuery $query): AnonymousResourceCollection
    {
        return HolidayPackagesResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
