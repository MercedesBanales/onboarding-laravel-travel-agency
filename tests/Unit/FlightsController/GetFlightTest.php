<?php

declare(strict_types=1);

namespace Tests\Unit\FlightsController;

use Illuminate\Http\JsonResponse;
use Illuminate\Testing\Fluent\AssertableJson;
use Lightit\Backoffice\Flights\App\Transformers\FlightTransformer;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

use function Pest\Laravel\getJson;
use function Pest\Laravel\seed;

describe('flights', function () {
    beforeEach(function () {
        seed();
    });

    it('can get an existing flight successfully', function () {
        $flight = Flight::inRandomOrder()->firstOrFail();

        $response = getJson(url("/api/flights/$flight->id"));

        $response
            ->assertSuccessful()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('status', JsonResponse::HTTP_OK)
                    ->where('success', true)
                    ->has(
                        'data',
                        fn (AssertableJson $json) =>
                        $json->whereAll(
                            transformation($flight, FlightTransformer::class)->transform() ?? []
                        )
                    )
            );
    });


    it('cannot get a flight that does not exist', function () {
        $flight_id = -1;

        $response = getJson(url("/api/flights/$flight_id"));

        $response
            ->assertNotFound();
    });
});
