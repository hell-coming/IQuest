<?php

namespace App\Http\ApiV1\AdminApi\Support\Enums;

enum NavigationGroup: string
{
    case BOOKING = 'Бронирование';

    case SCHEDULE = 'Расписание';

    case QUEST_COMPONENTS = 'Компоненты квестов';

    case LOCATIONS = 'Точки';

    case CONTACTS = 'Контакты';
}
