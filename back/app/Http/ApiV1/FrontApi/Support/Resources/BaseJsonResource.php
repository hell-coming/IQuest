<?php

namespace App\Http\ApiV1\FrontApi\Support\Resources;

use App\Http\ApiV1\FrontApi\Support\Pagination\Page;
use DateTimeInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseJsonResource extends JsonResource
{
    public const DATE_TIME_FORMAT = 'Y-m-d\TH:i:s.u\Z';
    public const DATE_FORMAT = 'Y-m-d';

    public function dateTimeToIso(?DateTimeInterface $datetime): ?string
    {
        return $datetime?->format(static::DATE_TIME_FORMAT);
    }

    public function dateToIso(?DateTimeInterface $date): ?string
    {
        return $date?->format(static::DATE_FORMAT);
    }

    public static function collectionWithPagination($resource, array $pagination): AnonymousResourceCollection
    {
        $collection = static::collection($resource);
        $currentAdditional = $collection->additional ?: [];
        $append = ['meta' => ['pagination' => $pagination]];

        return static::collection($resource)->additional(array_merge_recursive($currentAdditional, $append));
    }

    public static function collectPage(Page $page): AnonymousResourceCollection
    {
        return static::collectionWithPagination($page->items, $page->pagination);
    }
}
