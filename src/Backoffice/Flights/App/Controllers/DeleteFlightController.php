<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flights\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

class DeleteFlightController
{
    public function __invoke(Flight $flight): JsonResponse
    {
        $flight->delete();

        return responder()
            ->success()
            ->respond();
    }
}
