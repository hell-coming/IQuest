<?php

namespace App\Dto;

use Illuminate\Support\Fluent;

/**
 * class CertificateNewRequest
 *
 * @property string $new_request - Новая заявка
 * @property string $certificate - Тип сертификата
 * @property string $customer_name - Имя клиента
 * @property string $customer_phone - телефон клиента
 */
class CertificateNewRequest extends Fluent
{
    public function toArray(): array
    {
        return [
            "Новая заявка: $this->new_request",
            "Тип: $this->certificate",
            "Имя клиента: $this->customer_name",
            "Телефон: $this->customer_phone",
        ];
    }
}
