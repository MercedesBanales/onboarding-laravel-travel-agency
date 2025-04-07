<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\Domain\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Lightit\Backoffice\Cities\Domain\Filters\FilterCityByAirline;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ListCityAction
{
    /**
     * @return LengthAwarePaginator<Model>|Collection<int, Model>
     */
    public function execute(int|null $page = null): LengthAwarePaginator|Collection
    {
        $query = QueryBuilder::for(City::class)
            ->allowedFilters([
                AllowedFilter::callback('airline_name', new FilterCityByAirline())])
            ->allowedSorts('id', 'name')
            ->with('departure_flights')
            ->with('arrival_flights');
        
        if ($page) return $query->paginate(5);

        return $query->get();
    }
}
