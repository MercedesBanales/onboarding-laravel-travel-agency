<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Cities\App\Transformers\CityTransformer;
use Lightit\Backoffice\Cities\Domain\Models\City;

class GetCityController
{
    public function __invoke(City $city): JsonResponse
    {
        return responder()
            ->success($city, CityTransformer::class)
            ->respond();
    }
}
