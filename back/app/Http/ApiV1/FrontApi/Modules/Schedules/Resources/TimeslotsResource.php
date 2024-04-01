<?php

namespace App\Http\ApiV1\FrontApi\Modules\Schedules\Resources;

use App\Domain\Schedules\Models\Timeslot;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Timeslot
 */
class TimeslotsResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'time' => $this->time,
            'price' => price_format($this->price),
            'is_active' => $this->is_active,
        ];
    }
}
