<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\App\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lightit\Backoffice\Cities\App\Transformers\CityTransformer;
use Lightit\Backoffice\Cities\Domain\Actions\ListCityAction;

class ListCityController
{
    public function __invoke(Request $request, ListCityAction $action): JsonResponse
    {
        $cities = $action->execute((int)$request->query('page'));

        return responder()
            ->success($cities, CityTransformer::class)
            ->respond();
    }
}
