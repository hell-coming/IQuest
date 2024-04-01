<?php

namespace App\Http\ApiV1\FrontApi\Modules\Bookings\Controllers;

use App\Domain\Bookings\Actions\Bookings\CreateBookingAction;
use App\Http\ApiV1\FrontApi\Modules\Bookings\Requests\CreateBookingRequest;
use App\Http\ApiV1\FrontApi\Modules\Bookings\Resources\BookingsResource;

class BookingsController
{
    public function create(CreateBookingRequest $request, CreateBookingAction $action): BookingsResource
    {
        return new BookingsResource($action->execute($request->validated()));
    }
}
