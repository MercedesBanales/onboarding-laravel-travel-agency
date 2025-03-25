<?php

namespace Lightit\Backoffice\Airlines\Domain\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class FilterAirlineByActiveFlights implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query
            ->whereHas('flights', function (Builder $query) use ($value) {
                $query
                    ->where('arrival_date', '>', now());

            }, '=', $value);
    }
}
