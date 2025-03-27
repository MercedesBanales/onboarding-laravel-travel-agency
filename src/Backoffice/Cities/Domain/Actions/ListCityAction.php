<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\Domain\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lightit\Backoffice\Cities\Domain\Filters\FilterCityByAirline;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ListCityAction
{
    public const SORT_BY = ['id', 'name'];

    /**
     * @return Collection<int, Model>
     */
    public function execute(): Collection
    {
        return QueryBuilder::for(City::class)
            ->allowedFilters([
                AllowedFilter::callback('airline_id', new FilterCityByAirline())])
            ->allowedSorts(self::SORT_BY)
            ->with('departure_flights')
            ->with('arrival_flights')
            ->get();
    }
}
