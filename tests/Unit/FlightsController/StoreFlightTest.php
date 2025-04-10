<?php

declare(strict_types=1);

namespace Tests\Unit\FlightsController;

use Illuminate\Http\JsonResponse;
use Illuminate\Testing\Fluent\AssertableJson;
use Lightit\Backoffice\Airlines\Domain\Models\Airline;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\App\Transformers\FlightTransformer;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\postJson;
use function Pest\Laravel\seed;

describe('flights', function () {
    beforeEach(function () {
        seed();
    });

    it('can create a flight successfully', function () {
        $airline = Airline::inRandomOrder()->firstOrFail();
        $enabled_cities = $airline->enabled_cities;
        $departure_city = $enabled_cities->random();
        $arrival_city = $enabled_cities->reject(fn ($city) => $city->id == $departure_city->id)->random();
        $departure_date = '05-10-2025 23:48:01';
        $arrival_date = '10-10-2025 00:01:11';

        $request = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departure_city->id,
            'arrival_city_id' => $arrival_city->id,
            'departure_date' => $departure_date,
            'arrival_date' => $arrival_date,
        ];

        $response = postJson(url('/api/flights'), $request);

        $flight = Flight::query()
            ->where('id', $response['data'])
            ->firstOrFail();

        $response
            ->assertCreated()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('status', JsonResponse::HTTP_CREATED)
                    ->where('success', true)
                    ->has(
                        'data',
                        fn (AssertableJson $json) =>
                        $json->whereAll(
                            transformation($flight, FlightTransformer::class)->transform() ?? []
                        )
                    )
            );

        assertDatabaseHas('flights', [
            'airline_id' => $flight['airline_id'],
            'departure_city_id' => $flight['departure_city_id'],
            'arrival_city_id' => $flight['arrival_city_id'],
            'departure_date' => $flight['departure_date'],
            'arrival_date' => $flight['arrival_date'],
        ]);
    });

    it('cannot create a flight with an arrival date earlier than a departure date', function () {
        $airline = Airline::inRandomOrder()->firstOrFail();
        $enabled_cities = $airline->enabled_cities;
        $departure_city = $enabled_cities->random();
        $arrival_city = $enabled_cities->reject(fn ($city) => $city->id == $departure_city->id)->random();
        $departure_date = '07-10-2025 23:48:01';
        $arrival_date = '06-10-2025 00:01:11';

        $request = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departure_city->id,
            'arrival_city_id' => $arrival_city->id,
            'departure_date' => $departure_date,
            'arrival_date' => $arrival_date,
        ];

        $response = postJson(url('/api/flights'), $request);

        $response->assertUnprocessable()
        ->assertJsonValidationErrors(['arrival_date'], 'error.fields');

        assertDatabaseMissing('flights', [
            'airline_id' => $request['airline_id'],
            'departure_city_id' => $request['departure_city_id'],
            'arrival_city_id' => $request['arrival_city_id'],
            'departure_date' => $request['departure_date'],
            'arrival_date' => $request['arrival_date'],
        ]);
    });

    it('cannot create a flight with an airline id that does not exist', function () {
        $airline_id = -1;
        $departure_city_id = 1;
        $arrival_city_id = 2;
        $departure_date = '07-10-2025 23:48:01';
        $arrival_date = '06-10-2025 00:01:11';

        $request = [
            'airline_id' => $airline_id,
            'departure_city_id' => $departure_city_id,
            'arrival_city_id' => $arrival_city_id,
            'departure_date' => $departure_date,
            'arrival_date' => $arrival_date,
        ];

        $response = postJson(url('/api/flights'), $request);

        $response->assertNotFound();

        assertDatabaseMissing('flights', [
            'airline_id' => $request['airline_id'],
            'departure_city_id' => $request['departure_city_id'],
            'arrival_city_id' => $request['arrival_city_id'],
            'departure_date' => $request['departure_date'],
            'arrival_date' => $request['arrival_date'],
        ]);
    });

    it('cannot create a flight with a departure city that does not exist', function () {
        $airline = Airline::inRandomOrder()->firstOrFail();
        $enabled_cities = $airline->enabled_cities;
        $departure_city_id = -1;
        $arrival_city = $enabled_cities->random();
        $departure_date = '07-10-2025 23:48:01';
        $arrival_date = '06-10-2025 00:01:11';

        $request = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departure_city_id,
            'arrival_city_id' => $arrival_city->id,
            'departure_date' => $departure_date,
            'arrival_date' => $arrival_date,
        ];

        $response = postJson(url('/api/flights'), $request);

        $response->assertNotFound();

        assertDatabaseMissing('flights', [
            'airline_id' => $request['airline_id'],
            'departure_city_id' => $request['departure_city_id'],
            'arrival_city_id' => $request['arrival_city_id'],
            'departure_date' => $request['departure_date'],
            'arrival_date' => $request['arrival_date'],
        ]);
    });

    it('cannot create a flight with an arrival city that does not exist', function () {
        $airline = Airline::inRandomOrder()->firstOrFail();
        $enabled_cities = $airline->enabled_cities;
        $departure_city = $enabled_cities->random();
        $arrival_city_id = -1;
        $departure_date = '07-10-2025 23:48:01';
        $arrival_date = '06-10-2025 00:01:11';

        $request = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departure_city->id,
            'arrival_city_id' => $arrival_city_id,
            'departure_date' => $departure_date,
            'arrival_date' => $arrival_date,
        ];

        $response = postJson(url('/api/flights'), $request);

        $response->assertNotFound();

        assertDatabaseMissing('flights', [
            'airline_id' => $request['airline_id'],
            'departure_city_id' => $request['departure_city_id'],
            'arrival_city_id' => $request['arrival_city_id'],
            'departure_date' => $request['departure_date'],
            'arrival_date' => $request['arrival_date'],
        ]);
    });


    it('cannot create a flight with a departure city not enabled by the airline', function () {
        $airline = Airline::inRandomOrder()->firstOrFail();
        $enabled_cities = $airline->enabled_cities;
        $departure_city = City::whereNotIn('id', $enabled_cities->pluck('id'))->inRandomOrder()->firstOrFail();
        $arrival_city = $enabled_cities->random();
        $departure_date = '05-10-2025 23:48:01';
        $arrival_date = '06-10-2025 00:01:11';

        $request = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departure_city->id,
            'arrival_city_id' => $arrival_city->id,
            'departure_date' => $departure_date,
            'arrival_date' => $arrival_date,
        ];

        $response = postJson(url('/api/flights'), $request);

        $response->assertUnprocessable()
        ->assertJsonValidationErrors(['airline_id'], 'error.fields');

        assertDatabaseMissing('flights', [
            'airline_id' => $request['airline_id'],
            'departure_city_id' => $request['departure_city_id'],
            'arrival_city_id' => $request['arrival_city_id'],
            'departure_date' => $request['departure_date'],
            'arrival_date' => $request['arrival_date'],
        ]);
    });

    it('cannot create a flight with an arrival city not enabled by the airline', function () {
        $airline = Airline::inRandomOrder()->firstOrFail();
        $enabled_cities = $airline->enabled_cities;
        $departure_city = $enabled_cities->random();
        $arrival_city = City::whereNotIn('id', $enabled_cities->pluck('id'))->inRandomOrder()->firstOrFail();
        $departure_date = '05-10-2025 23:48:01';
        $arrival_date = '06-10-2025 00:01:11';

        $request = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departure_city->id,
            'arrival_city_id' => $arrival_city->id,
            'departure_date' => $departure_date,
            'arrival_date' => $arrival_date,
        ];

        $response = postJson(url('/api/flights'), $request);

        $response->assertUnprocessable()
        ->assertJsonValidationErrors(['airline_id'], 'error.fields');

        assertDatabaseMissing('flights', [
            'airline_id' => $request['airline_id'],
            'departure_city_id' => $request['departure_city_id'],
            'arrival_city_id' => $request['arrival_city_id'],
            'departure_date' => $request['departure_date'],
            'arrival_date' => $request['arrival_date'],
        ]);
    });
});
