<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Queries;

use App\Domain\Holidays\Models\Holiday;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class HolidaysQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Holiday::query());

        $this->allowedIncludes([
            'packages',
        ]);

        $this->allowedFilters([
            AllowedFilter::callback('is_active', fn($query, $value) => $query->where('is_active', $value)),
        ]);

        $this->defaultSort('id');
    }
}
