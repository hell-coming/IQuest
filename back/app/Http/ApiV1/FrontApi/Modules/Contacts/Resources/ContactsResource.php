<?php

namespace App\Http\ApiV1\FrontApi\Modules\Contacts\Resources;

use App\Domain\Contacts\Models\Contact;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\CitiesResource;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Contact
 */
class ContactsResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'city' => new CitiesResource($this->whenLoaded('city')),
            'type' => new ContactTypesResource($this->whenLoaded('contactType')),
            'value' => $this->value
        ];
    }
}
