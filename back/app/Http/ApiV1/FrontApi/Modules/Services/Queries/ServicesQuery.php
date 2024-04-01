<?php

namespace App\Http\ApiV1\FrontApi\Modules\Services\Queries;

use App\Domain\Services\Models\Service;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ServicesQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Service::query());

        $this->allowedFilters([
            AllowedFilter::exact('city_id', 'city_id'),
        ]);

        $this->allowedSorts([
            'name',
        ]);

        $this->defaultSort('id');
    }
}
