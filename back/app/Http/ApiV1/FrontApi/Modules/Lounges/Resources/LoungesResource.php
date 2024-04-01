<?php

namespace App\Http\ApiV1\FrontApi\Modules\Lounges\Resources;

use App\Domain\Lounges\Models\Lounge;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\FilialsResource;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Lounge
 */
class LoungesResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'cover' => $this->cover ? config('app.url') . Storage::url($this->cover) : null,
            'max_people' => $this->max_people,
            'price_per_half_hour' => price_format($this->price_per_half_hour),
            'price_per_hour' => price_format($this->price_per_hour),
            'filial' => new FilialsResource($this->whenLoaded('filial')),
        ];
    }
}
