<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\Domain\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Lightit\Backoffice\Airlines\Domain\Filters\FilterAirlineByActiveFlights;
use Lightit\Backoffice\Airlines\Domain\Filters\FilterAirlineByCity;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Spatie\QueryBuilder\AllowedFilter;

use Spatie\QueryBuilder\QueryBuilder;

class ListAirlineAction
{
    /**
     * @return LengthAwarePaginator<Model>|Collection<int, Model>
    */
    public function execute(int|null $page = null): LengthAwarePaginator|Collection
    {
        $query = QueryBuilder::for(Airline::class)
            ->allowedFilters([
                AllowedFilter::callback('num_active_flights', new FilterAirlineByActiveFlights()),
                AllowedFilter::callback('city_id', new FilterAirlineByCity())])
            ->with('enabledCities')
            ->with('flights');
        
        if ($page) {
            return $query->paginate(5);
        }

        return $query->get();
    }
}
