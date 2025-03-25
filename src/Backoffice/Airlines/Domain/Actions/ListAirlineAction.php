<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\Domain\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lightit\Backoffice\Airlines\Domain\Filters\FilterAirlineByActiveFlights;
use Lightit\Backoffice\Airlines\Domain\Filters\FilterAirlineByCity;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ListAirlineAction
{
    /**
     * @return Collection<int, Model>
     */
    public function execute(): Collection
    {
        return QueryBuilder::for(Airline::class)
            ->with('enabled_cities')
            ->with('flights')
            ->allowedFilters([
                AllowedFilter::callback('num_active_flights', new FilterAirlineByActiveFlights()),
                AllowedFilter::callback('city_id', new FilterAirlineByCity())])
            ->get();
    }
}
