<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Transformers;

use Flugg\Responder\Transformers\Transformer;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class FlightTransformer extends Transformer
{
    /**
     * Transform the model.
     *
     *
     * @return array
     */
    public function transform(Flight $flight)
    {
        return [
            'id' => $flight->id,
            'airline' => $flight->airline,
            'departureCity' => $flight->departureCity,
            'arrivalCity' => $flight->arrivalCity,
            'departure_date' => $flight->departureCity->dateToTimezone(
                $flight->departure_date->toDateString()
            )->format(
                'd-m-Y H:i:s'
            ),
            'arrival_date' => $flight->arrivalCity->dateToTimezone($flight->arrival_date->toDateString())->format(
                'd-m-Y H:i:s'
            ),
        ];
    }
}
