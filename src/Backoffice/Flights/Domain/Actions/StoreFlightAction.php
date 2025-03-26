<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\Domain\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lightit\Backoffice\Flights\Domain\DataTransferObjects\FlightDto;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class StoreFlightAction
{
    /**
     * @return Flight
     */
    public function execute(FlightDto $dto): Flight
    {
        return Flight::create([
            'airline_id' => $dto->airline_id,
            'departure_city_id' => $dto->departure_city_id,
            'arrival_city_id' => $dto->arrival_city_id,
            'departure_date' => $dto->departure_date,
            'arrival_date' => $dto->arrival_date,
        ]);
    }
}
