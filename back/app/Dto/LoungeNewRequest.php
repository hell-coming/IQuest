<?php

namespace App\Dto;

use Illuminate\Support\Fluent;

/**
 * Class LoungeNewRequest
 *
 * @property string $new_request - Новая заявка
 * @property string $lounge - Комната
 * @property string $date_and_time - Дата и время
 * @property string $customer_name - Имя клиента
 * @property string $customer_phone - телефон клиента
 */
class LoungeNewRequest extends Fluent
{

    public function toArray(): array
    {
        if ($this->lounge) {
            return [
                "Новая заявка: $this->new_request",
                "Комната: $this->lounge",
                "Дата и время: $this->date_and_time",
                "Имя клиента: $this->customer_name",
                "Телефон: $this->customer_phone"
            ];
        }

        return [
            "Новая заявка: $this->new_request",
            "Имя клиента: $this->customer_name",
            "Телефон: $this->customer_phone"
        ];
    }
}
