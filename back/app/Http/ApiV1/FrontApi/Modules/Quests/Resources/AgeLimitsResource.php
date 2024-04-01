<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Resources;

use App\Domain\Quests\Models\AgeLimit;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin AgeLimit
 */
class AgeLimitsResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->limit,
        ];
    }
}
