<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flights\App\Transformers\FlightTransformer;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class GetFlightController
{
    public function __invoke(Flight $flight): JsonResponse
    {
        return responder()
            ->success($flight, FlightTransformer::class)
            ->respond();
    }
}
