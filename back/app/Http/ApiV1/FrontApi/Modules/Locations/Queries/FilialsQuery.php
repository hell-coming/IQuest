<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Queries;

use App\Domain\Locations\Models\Filial;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FilialsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Filial::query());

        $this->allowedIncludes([
            'city',
            'lounges',
        ]);

        $this->allowedFilters([
            AllowedFilter::exact('city_id', 'city_id'),
            AllowedFilter::scope('lounge_is_active', 'loungeIsActive'),
        ]);

        $this->defaultSort('id');
    }
}
