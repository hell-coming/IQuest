<?php

namespace App\Http\ApiV1\FrontApi\Modules\Schedules\Resources;

use App\Domain\Schedules\Models\ScheduleQuest;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin ScheduleQuest
 */
class ScheduleQuestsResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'quest' => $this->quest_id,
            'date' => $this->date,
            'timeslots' => TimeslotsResource::collection($this->whenLoaded('timeslots')),
        ];
    }
}
