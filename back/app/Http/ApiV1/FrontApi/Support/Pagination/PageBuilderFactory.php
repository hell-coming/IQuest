<?php

namespace App\Http\ApiV1\FrontApi\Support\Pagination;

use App\Http\ApiV1\FrontApi\Enums\PaginationTypeEnum;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

class PageBuilderFactory
{
    public function fromQuery(QueryBuilder|EloquentQueryBuilder|SpatieQueryBuilder $query, ?Request $request = null): AbstractPageBuilder
    {
        $request = $request ?: resolve(Request::class);

        return $request->input('pagination.type', config('pagination.default_type')) === PaginationTypeEnum::CURSOR->value
            ? new CursorPageBuilder($query, $request)
            : new OffsetPageBuilder($query, $request);
    }
}
