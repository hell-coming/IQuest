<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Queries;

use App\Domain\Quests\Models\Quest;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class QuestsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Quest::query());

        $this->allowedIncludes([
            'type',
            'genre',
            'age_limit',
            'filial',
            'images',
        ]);

        $this->allowedFilters([
            AllowedFilter::exact('city_id', 'filial.city_id'),
            AllowedFilter::callback('is_active', fn($query, $value) => $query->where('is_active', $value)),
        ]);

        $this->allowedSorts([
            AllowedSort::field('sequence_number'),
            AllowedSort::field('type', 'type_id'),
            AllowedSort::field('genre', 'genre_id'),
            AllowedSort::field('age_limit', 'age_limit_id'),
        ]);

        $this->defaultSort('sequence_number');
    }
}
