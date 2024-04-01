<?php

namespace App\Http\ApiV1\FrontApi\Modules\Bookings\Resources;

use App\Domain\Bookings\Models\Booking;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin  Booking
 */

class BookingsResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'type' => $this->type,
        ];
    }
}
