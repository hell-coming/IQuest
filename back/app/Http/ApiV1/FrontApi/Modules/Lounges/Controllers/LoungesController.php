<?php

namespace App\Http\ApiV1\FrontApi\Modules\Lounges\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Lounges\Queries\LoungesQuery;
use App\Http\ApiV1\FrontApi\Modules\Lounges\Resources\LoungesResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LoungesController
{
    public function get(int $id, LoungesQuery $query): LoungesResource
    {
        return new LoungesResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, LoungesQuery $query): AnonymousResourceCollection
    {
        return LoungesResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
