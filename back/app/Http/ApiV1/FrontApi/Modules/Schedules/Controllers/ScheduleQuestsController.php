<?php

namespace App\Http\ApiV1\FrontApi\Modules\Schedules\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Schedules\Queries\ScheduleQuestsQuery;
use App\Http\ApiV1\FrontApi\Modules\Schedules\Resources\ScheduleQuestsResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ScheduleQuestsController
{
    public function get(int $id, ScheduleQuestsQuery $query): ScheduleQuestsResource
    {
        return new ScheduleQuestsResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, ScheduleQuestsQuery $query): AnonymousResourceCollection
    {
        return ScheduleQuestsResource::collectPage(
            $pageBuilderFactory->fromQuery($query->withoutTrashed())->build()
        );
    }
}
