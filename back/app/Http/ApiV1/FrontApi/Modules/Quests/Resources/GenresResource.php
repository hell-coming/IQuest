<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Resources;

use App\Domain\Quests\Models\Genre;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Genre
 */
class GenresResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
