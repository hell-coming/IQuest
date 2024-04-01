<?php

namespace App\Http\ApiV1\FrontApi\Modules\Contacts\Resources;

use App\Domain\Contacts\Models\ContactType;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\CitiesResource;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin ContactType
 */
class ContactTypesResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_social' => $this->is_social
        ];
    }
}
