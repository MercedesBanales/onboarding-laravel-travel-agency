<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\App\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lightit\Backoffice\Airlines\App\Transformers\AirlineTransformer;
use Lightit\Backoffice\Airlines\Domain\Actions\ListAirlineAction;

class ListAirlineController
{
    public function __invoke(Request $request, ListAirlineAction $action): JsonResponse
    {
        $airlines = $action->execute((int)$request->query('page'));

        return responder()
            ->success($airlines, AirlineTransformer::class)
            ->respond();
    }
}
