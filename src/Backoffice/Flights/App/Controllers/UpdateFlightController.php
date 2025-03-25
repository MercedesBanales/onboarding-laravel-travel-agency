<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flights\App\Requests\UpdateFlightRequest;
use Lightit\Backoffice\Flights\App\Transformers\FlightTransformer;
use Lightit\Backoffice\Flights\Domain\Actions\UpdateFlightAction;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class UpdateFlightController
{
    public function __invoke(Flight $flight, UpdateFlightRequest $request, UpdateFlightAction $action): JsonResponse
    {
        $flight = $action->execute($flight, $request->toDto());

        return responder()
            ->success($flight, FlightTransformer::class)
            ->respond();
    }
}
