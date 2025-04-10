<?php

declare(strict_types=1);

namespace Tests\Unit\FlightsController;

use Illuminate\Http\JsonResponse;
use Illuminate\Testing\Fluent\AssertableJson;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

use function Pest\Laravel\getJson;
use function Pest\Laravel\seed;

describe('flights', function () {
    beforeEach(function () {
        seed();
    });

    it('can list flights successfully', function () {
        $flights = Flight::with(['airline', 'departure_city', 'arrival_city'])->get();
    
        getJson(url('/api/flights'))
            ->assertSuccessful()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
                    ->has('pagination')
                    ->where('pagination.total', $flights->count())
                    ->where('status', JsonResponse::HTTP_OK)
                    ->where('success', true)
            );
    });
});
