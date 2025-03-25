<?php

namespace Lightit\Backoffice\Airlines\Domain\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterAirlineByCity implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query
            ->whereHas('flights', function (Builder $query) use ($value) {
                $query->where('departure_city_id', $value)
                    ->orWhere('arrival_city_id', $value);
            });

    }
}
