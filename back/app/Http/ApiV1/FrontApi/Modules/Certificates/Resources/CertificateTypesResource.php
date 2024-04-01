<?php

namespace App\Http\ApiV1\FrontApi\Modules\Certificates\Resources;

use App\Domain\Certificates\Models\CertificateType;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin CertificateType
 */
class CertificateTypesResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => price_format($this->price),
            'cover' => $this->cover ? config('app.url') . Storage::url($this->cover) : null,
        ];
    }
}
