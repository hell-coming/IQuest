<?php

namespace App\Http\ApiV1\FrontApi\Modules\Services\Resources;

use App\Domain\Services\Models\Service;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Service
 */
class ServicesResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => price_format($this->price),
            'unit' => $this->unit,
        ];
    }
}
