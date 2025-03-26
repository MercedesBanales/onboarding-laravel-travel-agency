<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\App\Requests;

use Carbon\CarbonTimeZone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\Cities\Domain\DataTransferObjects\CityDto;
use Lightit\Backoffice\Cities\Domain\Models\City;

class StoreCityRequest extends FormRequest
{
    public const NAME = 'name';

    public const TIMEZONE = 'timezone';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            self::NAME => ['required', Rule::unique(City::class)],
            self::TIMEZONE => ['required', 'timezone:all'],
        ];
    }

    public function toDto(): CityDto
    {
        /**
         * @var CarbonTimeZone $timezone
         */
        $timezone = CarbonTimeZone::create($this->string(self::TIMEZONE)->toString());
        
        return new CityDto(
            name: $this->string(self::NAME)->toString(),
            timezone: $timezone
        );
    }
}
