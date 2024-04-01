<?php

namespace App\Http\ApiV1\FrontApi\Enums;

/**
 * Pagination types:
 * * `cursor` - Пагинация используя cursor
 * * `offset` - Пагинация используя offset
 */
enum PaginationTypeEnum: string
{
    case CURSOR = 'cursor';
    case OFFSET = 'offset';
}
