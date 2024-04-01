<?php

namespace App\Dto;

use Illuminate\Support\Fluent;

/**
 * class QuestNewRequest
 *
 * @property string $new_request - Новая заявка
 * @property string $quest - Квест
 * @property string $date_and_time - Дата и время
 * @property string $customer_name - Имя клиента
 * @property string $customer_phone - телефон клиента
 * @property string $count_participants - Кол - во участников
 * @property string $final_price - Цена
 * @property string $comment - Комментарий
 */
class QuestNewRequest extends Fluent
{
    public function toArray(): array
    {
        return [
            "Новая заявка: $this->new_request",
            "Квест: $this->quest",
            "Дата и время: $this->date_and_time",
            "Имя клиента: $this->customer_name",
            "Телефон: $this->customer_phone",
            "Кол - во участников: $this->count_participants",
            "Цена: $this->final_price",
            "Комментарий: $this->comment"
        ];
    }
}
