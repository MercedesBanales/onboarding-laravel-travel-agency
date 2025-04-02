<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\Domain\Actions;

use Illuminate\Database\Eloquent\Model;
use Lightit\Backoffice\Airlines\Domain\Filters\FilterAirlineByActiveFlights;
use Lightit\Backoffice\Airlines\Domain\Filters\FilterAirlineByCity;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Pagination\LengthAwarePaginator;

class ListAirlineAction
{
     /**
     * @return LengthAwarePaginator<Model>
     */
    public function execute(): LengthAwarePaginator
    {
        return QueryBuilder::for(Airline::class)
            ->allowedFilters([
                AllowedFilter::callback('num_active_flights', new FilterAirlineByActiveFlights()),
                AllowedFilter::callback('city_id', new FilterAirlineByCity())])
            ->with('enabled_cities')
            ->with('flights')
            ->paginate(5);
    }
}
