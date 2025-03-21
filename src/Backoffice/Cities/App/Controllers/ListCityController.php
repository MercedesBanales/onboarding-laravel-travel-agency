<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Cities\App\Transformers\CityTransformer;
use Lightit\Backoffice\Cities\Domain\Actions\ListCityAction;

class ListCityController
{
    public function __invoke(ListCityAction $action): JsonResponse
    {
        $cities = $action->execute();

        return responder()
            ->success($cities, CityTransformer::class)
            ->respond();
    }
}
