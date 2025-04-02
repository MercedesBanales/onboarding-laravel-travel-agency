<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\Domain\Actions;

use Illuminate\Database\Eloquent\Model;
use Lightit\Backoffice\Cities\Domain\Filters\FilterCityByAirline;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;

class ListCityAction
{
    /**
     * @return LengthAwarePaginator<Model>
     */
    public function execute(): LengthAwarePaginator
    {
        return QueryBuilder::for(City::class)
            ->allowedFilters([
                AllowedFilter::callback('airline_name', new FilterCityByAirline())])
            ->allowedSorts('id', 'name')
            ->with('departure_flights')
            ->with('arrival_flights')
            ->paginate(5);
    }
}
