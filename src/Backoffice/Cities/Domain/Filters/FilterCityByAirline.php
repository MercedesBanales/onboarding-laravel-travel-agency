<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Spatie\QueryBuilder\Filters\Filter;

/**
 * @implements Filter<City>
 */
class FilterCityByAirline implements Filter
{
    /**
     * @param Builder<City> $query
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query
        ->whereHas('departure_flights', function (Builder $query) use ($value) {
            $query->join('airlines', 'flights.airline_id', '=', 'airlines.id')
                ->whereRaw('LOWER(airlines.name) LIKE ?', ['%' . strtolower($value) . '%']);
        })
        ->orWhereHas('arrival_flights', function (Builder $query) use ($value) {
            $query->join('airlines', 'flights.airline_id', '=', 'airlines.id')
                ->whereRaw('LOWER(airlines.name) LIKE ?', ['%' . strtolower($value) . '%']);
        });
    }
}
