<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Resources;

use App\Domain\Locations\Models\City;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin City
 */
class CitiesResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
