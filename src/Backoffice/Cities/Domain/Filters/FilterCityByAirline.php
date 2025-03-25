<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterCityByAirline implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query
            ->whereHas('departure_flights', function (Builder $query) use ($value) {
                $query->where('airline_id', $value);
            })
            ->orWhereHas('arrival_flights', function (Builder $query) use ($value) {
                $query->where('airline_id', $value);
            });
    }
}
