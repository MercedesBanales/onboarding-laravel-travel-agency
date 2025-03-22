<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\Domain\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lightit\Backoffice\Flights\Domain\DataTransferObjects\FlightDto;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class UpdateFlightAction
{
    /**
     * @return Collection<int, Model>
     */
    public function execute(Flight $flight, FlightDto $dto): Flight
    {
        $flight->update([
            'departure_city_id' => $dto->departure_city_id ?? $flight->departure_city_id,
            'arrival_city_id' => $dto->arrival_city_id ?? $flight->arrival_city_id,
            'departure_date' => $dto->departure_date ?? $flight->departure_date,
            'arrival_date' => $dto->arrival_date ?? $flight->arrival_date
        ]);

        return $flight;
    }
}
