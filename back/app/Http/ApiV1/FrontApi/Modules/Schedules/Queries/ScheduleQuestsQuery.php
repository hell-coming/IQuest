<?php

namespace App\Http\ApiV1\FrontApi\Modules\Schedules\Queries;

use App\Domain\Schedules\Models\ScheduleQuest;
use Carbon\Carbon;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class ScheduleQuestsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(ScheduleQuest::query());

        $this->allowedIncludes([
            AllowedInclude::callback('timeslots', function ($query) {
                $query->withoutTrashed();
            })
        ]);

        $this->allowedFilters([
            AllowedFilter::exact('quest_id', 'quest_id'),
            AllowedFilter::callback('today', fn($query, $value) => $query
                ->when($value, fn($query) => $query->whereDate('date', Carbon::today()))),
            AllowedFilter::callback('tomorrow', fn($query, $value) => $query
                ->when($value, fn($query) => $query->whereDate('date', Carbon::tomorrow()))),
            AllowedFilter::callback('weekend', function ($query, $value) {
                $sunday = Carbon::now()->endOfWeek();
                $saturday = $sunday->copy()->subDay();
                $query->when($value, fn($query) => $query->whereIn('date', [$saturday, $sunday]));
            }),
            AllowedFilter::callback('between', function ($query, $value) {
                $query->whereBetween('date', $value);
            })
        ]);

        $this->defaultSorts([
            'date',
        ]);
    }
}
