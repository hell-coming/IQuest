<?php

namespace App\Http\ApiV1\FrontApi\Modules\Sales\Resources;

use App\Domain\Sales\Models\Sale;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Sale
 */
class SalesResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->header,
            'description' => $this->description,
            'front_image' => $this->front_image ? config('app.url') . Storage::url($this->front_image) : null,
            'back_image' => $this->back_image ? config('app.url') . Storage::url($this->back_image) : null,
        ];
    }
}
