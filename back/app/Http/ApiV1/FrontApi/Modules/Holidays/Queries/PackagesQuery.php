<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Queries;

use App\Domain\Holidays\Models\Package;
use Spatie\QueryBuilder\QueryBuilder;

class PackagesQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Package::query());

        $this->allowedSorts([
            'sequence_number',
        ]);

        $this->defaultSort('sequence_number');
    }
}
