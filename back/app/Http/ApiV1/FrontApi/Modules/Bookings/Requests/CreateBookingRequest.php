<?php

namespace App\Http\ApiV1\FrontApi\Modules\Bookings\Requests;

use App\Domain\Bookings\Enums\BookingType;
use App\Http\ApiV1\AdminApi\Filament\Rules\NameRule;
use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;


class CreateBookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'booking.name' => ['required', 'string', 'between:1,40', new NameRule],
            'booking.phone' => ['required', 'string', new PhoneRule],
            'booking.type' => ['required', new Enum(BookingType::class)],
            'booking.city_id' => ['required', 'integer', Rule::exists('cities', 'id')],

            'schedule_quest.timeslot_id' => ['nullable', 'integer', Rule::exists('timeslots', 'id')],
            'schedule_quest.count_participants' => ['nullable', 'integer', 'between:1,255'],
            'schedule_quest.final_price' => ['nullable', 'numeric', 'min:1', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'schedule_quest.comment' => ['nullable', 'string', 'max:125'],

            'holiday.holiday_id' => ['nullable', 'integer'],
            'holiday.package_id' => ['nullable', 'integer'],

            'certificate_type_id' => ['nullable', 'integer', Rule::exists('certificate_types', 'id')],
        ];
    }
}
