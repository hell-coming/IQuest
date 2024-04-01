<?php

namespace App\Http\ApiV1\FrontApi\Modules\Contacts\Queries;

use App\Domain\Contacts\Models\Contact;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ContactsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Contact::query());

        $this->allowedIncludes([
            'city',
            'contactType',
        ]);

        $this->allowedFilters([
            AllowedFilter::exact('city_id', 'city_id'),
            AllowedFilter::exact('contact_name', 'contactType.name'),
        ]);
    }
}
