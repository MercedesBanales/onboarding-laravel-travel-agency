<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airlines\App\Transformers\AirlineTransformer;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;

class GetAirlineController
{
    public function __invoke(Airline $airline): JsonResponse
    {
        return responder()
            ->success($airline, AirlineTransformer::class)
            ->respond();
    }
}
