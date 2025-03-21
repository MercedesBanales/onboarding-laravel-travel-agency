<?php

namespace Lightit\Backoffice\Cities\App\Transformers;

use Flugg\Responder\Transformers\Transformer;
use Lightit\Backoffice\Cities\Domain\Models\City;

class CityTransformer extends Transformer
{
    /**
     * Transform the model.
     *
     * @param City $city
     *
     * @return array
     */
    public function transform(City $city)
    {
        return [
            'id' => $city->id,
            'name' => $city->name,
        ];
    }
}
