<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Spatie\QueryBuilder\Filters\Filter;

/**
 * @implements Filter<Airline>
 */
class FilterAirlineByCity implements Filter
{
    /**
     * @param mixed $value
     */
    public function __invoke(Builder $query, $value, string $property)
    {
        $query
            ->whereHas('flights', function (Builder $query) use ($value) {
                $query->where('departure_city_id', $value)
                    ->orWhere('arrival_city_id', $value);
            });
    }
}
