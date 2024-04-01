<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Resources;

use App\Domain\Holidays\Models\Holiday;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Holiday
 */
class HolidaysResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'packages' => PackagesResource::collection($this->whenLoaded('packages')),
        ];
    }
}
