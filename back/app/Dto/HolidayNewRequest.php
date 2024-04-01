<?php

namespace App\Dto;

use Illuminate\Support\Fluent;

/**
 * class CertificateNewRequest
 *
 * @property string $new_request - Новая заявка
 * @property string $holiday - Вид праздника
 * @property string $package - Пакет праздника
 * @property string $customer_name - Имя клиента
 * @property string $customer_phone - телефон клиента
 */
class HolidayNewRequest extends Fluent
{
    public function toArray(): array
    {
        return [
            "Новая заявка: $this->new_request",
            "Праздник: $this->holiday",
            "Пакет: $this->package",
            "Имя клиента: $this->customer_name",
            "Телефон: $this->customer_phone",
        ];
    }
}
