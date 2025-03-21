<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Cities\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Backoffice\Cities\Domain\DataTransferObjects\CityDto;

class UpdateCityRequest extends FormRequest
{
    public const NAME = 'name';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }

    public function toDto(): CityDto
    {
        return new CityDto(
            name: $this->string(self::NAME)?->toString() ?: null
        );
    }
}
