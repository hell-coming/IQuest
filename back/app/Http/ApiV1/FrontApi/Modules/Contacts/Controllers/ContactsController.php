<?php

namespace App\Http\ApiV1\FrontApi\Modules\Contacts\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Contacts\Queries\ContactsQuery;
use App\Http\ApiV1\FrontApi\Modules\Contacts\Resources\ContactsResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContactsController
{
    public function get(int $id, ContactsQuery $query): ContactsResource
    {
        return new ContactsResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, ContactsQuery $query): AnonymousResourceCollection
    {
        return ContactsResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
