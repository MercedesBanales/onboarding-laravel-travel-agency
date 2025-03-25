<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airlines\App\Requests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\Airlines\Domain\DataTransferObjects\AirlineDto;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;

class StoreAirlineRequest extends FormRequest
{
    public const NAME = 'name';

    public const ENABLED_CITIES_IDS = 'enabled_cities_ids';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            self::NAME => ['required', Rule::unique(Airline::class)],
            self::ENABLED_CITIES_IDS => [
                    'required', 
                    Rule::array(), 'min:1', 
                    Rule::exists(City::class, 'id')]
        ];
    }

    public function toDto(): AirlineDto
    {
        return new AirlineDto(
            name: $this->string(self::NAME)->toString(),
            enabled_cities_ids: $this->array(self::ENABLED_CITIES_IDS)
        );
    }
}
