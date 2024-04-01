<?php

namespace App\Http\ApiV1\FrontApi\Modules\Sales\Queries;

use App\Domain\Sales\Models\Sale;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SalesQuery extends QueryBuilder
{

    public function __construct()
    {
        parent::__construct(Sale::query());

        $this->allowedFilters([
            AllowedFilter::exact('city_id', 'city_id'),
            AllowedFilter::callback('is_active', fn($query, $value) => $query->where('is_active', $value)),
        ]);

        $this->defaultSort('id');
    }
}
