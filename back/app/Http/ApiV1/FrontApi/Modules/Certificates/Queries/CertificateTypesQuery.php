<?php

namespace App\Http\ApiV1\FrontApi\Modules\Certificates\Queries;

use App\Domain\Certificates\Models\CertificateType;
use Spatie\QueryBuilder\QueryBuilder;

class CertificateTypesQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(CertificateType::query());

        $this->allowedSorts([
            'price',
        ]);

        $this->defaultSort('price');
    }
}
