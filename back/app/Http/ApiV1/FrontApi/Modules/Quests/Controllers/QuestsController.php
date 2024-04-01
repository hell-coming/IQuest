<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Quests\Queries\QuestsQuery;
use App\Http\ApiV1\FrontApi\Modules\Quests\Resources\QuestsResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuestsController
{

    public function get(int $id, QuestsQuery $query): QuestsResource
    {
        return new QuestsResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, QuestsQuery $query): AnonymousResourceCollection
    {
        return QuestsResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
