<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\Domain\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lightit\Backoffice\Flights\Domain\Models\Flight;
use Spatie\QueryBuilder\QueryBuilder;

class ListFlightAction
{
    /**
     * @return Collection<int, Model>
     */
    public function execute(): Collection
    {
        return QueryBuilder::for(Flight::class)
            ->with('departure_city')
            ->with('arrival_city')
            ->with('airline')
            ->get();
    }
}
