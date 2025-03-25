<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flights\App\Requests\StoreFlightRequest;
use Lightit\Backoffice\Flights\App\Transformers\FlightTransformer;
use Lightit\Backoffice\Flights\Domain\Actions\StoreFlightAction;

class StoreFlightController
{
    public function __invoke(StoreFlightRequest $request, StoreFlightAction $action): JsonResponse
    {
        $flight = $action->execute($request->toDto());

        return responder()
            ->success($flight, FlightTransformer::class)
            ->respond(JsonResponse::HTTP_CREATED);
    }
}
