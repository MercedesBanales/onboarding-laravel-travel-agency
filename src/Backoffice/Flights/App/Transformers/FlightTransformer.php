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
            'departure_city' => $flight->departure_city,
            'arrival_city' => $flight->arrival_city,
            'departure_date' => $flight->departure_date,
            'arrival_date' => $flight->arrival_date,
        ];
    }
}
