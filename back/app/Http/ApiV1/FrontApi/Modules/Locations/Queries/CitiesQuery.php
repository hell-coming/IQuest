<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Queries;

use App\Domain\Locations\Models\City;
use Spatie\QueryBuilder\QueryBuilder;

class CitiesQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(City::query());

        $this->allowedSorts([
            'name'
        ]);

        $this->defaultSort('id');
    }
}
