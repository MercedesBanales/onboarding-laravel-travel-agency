<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flights\App\Transformers\FlightTransformer;
use Lightit\Backoffice\Flights\Domain\Actions\ListFlightAction;

class ListFlightController
{
    public function __invoke(ListFlightAction $action): JsonResponse
    {
        $flights = $action->execute();

        return responder()
            ->success($flights, FlightTransformer::class)
            ->respond();
    }
}
