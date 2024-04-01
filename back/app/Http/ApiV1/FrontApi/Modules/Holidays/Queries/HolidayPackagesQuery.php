<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Queries;

use App\Domain\Holidays\Models\HolidayPackage;
use Spatie\QueryBuilder\QueryBuilder;

class HolidayPackagesQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(HolidayPackage::query());
    }
}
