<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

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
