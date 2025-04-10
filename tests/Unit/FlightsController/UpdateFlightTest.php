<?php

declare(strict_types=1);

namespace Tests\Unit\FlightsController;

use Illuminate\Http\JsonResponse;
use Illuminate\Testing\Fluent\AssertableJson;
use Lightit\Backoffice\Cities\Domain\Models\City;
use Lightit\Backoffice\Flights\Domain\Models\Flight;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\seed;

describe('flights', function () {
    beforeEach(function () {
        seed();
    });

    it('can update a flight successfully', function () {
        $flight = Flight::inRandomOrder()->firstOrFail();
        $airline = $flight->airline;
        $new_departure_city = $airline->enabled_cities
            ->reject(fn ($city) => $city->id == $flight->departure_city->id || $city->id == $flight->arrival_city->id)
            ->random();

        $request = [
            'departure_city_id' => $new_departure_city->id,
        ];

        $response = patchJson(url("/api/flights/$flight->id"), $request);

        $updated_flight = Flight::query()
            ->where('id', $response['data'])
            ->firstOrFail();

        $response
        ->assertSuccessful()
        ->assertJson(
            fn (AssertableJson $json) =>
            $json->where('status', JsonResponse::HTTP_OK)
                ->where('success', true)
                ->where('data.departure_city.id', $new_departure_city->id)
        );

        assertDatabaseHas('flights', [
            'airline_id' => $updated_flight['airline_id'],
            'departure_city_id' => $updated_flight['departure_city_id'],
            'arrival_city_id' => $updated_flight['arrival_city_id'],
            'departure_date' => $updated_flight['departure_date'],
            'arrival_date' => $updated_flight['arrival_date'],
        ]);
    });

    it("cannot update a flight's arrival date earlier than a departure date", function () {
        $flight = Flight::inRandomOrder()->firstOrFail();
        $departure_date = '07-10-2025 23:48:01';
        $arrival_date = '06-10-2025 00:01:11';

        $request = [
            'departure_date' => $departure_date,
            'arrival_date' => $arrival_date,
        ];

        $response = patchJson(url("/api/flights/$flight->id"), $request);

        $response->assertUnprocessable()
        ->assertJsonValidationErrors(['arrival_date'], 'error.fields');

        assertDatabaseMissing('flights', [
            'airline_id' => $flight['airline_id'],
            'departure_city_id' => $flight['departure_city_id'],
            'arrival_city_id' => $flight['arrival_city_id'],
            'departure_date' => $request['departure_date'],
            'arrival_date' => $request['arrival_date'],
        ]);
    });

    it("cannot update flight's airline id that does not exist", function () {
        $flight = Flight::inRandomOrder()->firstOrFail();
        $airline_id = -1;

        $request = [
            'airline_id' => $airline_id,
        ];

        $response = patchJson(url("/api/flights/$flight->id"), $request);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['airline_id'], 'error.fields');
            
        assertDatabaseMissing('flights', [
                'airline_id' => $request['airline_id'],
                'departure_city_id' => $flight['departure_city_id'],
                'arrival_city_id' => $flight['arrival_city_id'],
                'departure_date' => $flight['departure_date'],
                'arrival_date' => $flight['arrival_date'],
        ]);
    });

    it("cannot update flight's departure city id that does not exist", function () {
        $flight = Flight::inRandomOrder()->firstOrFail();
        $departure_city_id = -1;

        $request = [
            'departure_city_id' => $departure_city_id,
        ];

        $response = patchJson(url("/api/flights/$flight->id"), $request);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['departure_city_id'], 'error.fields');
            
        assertDatabaseMissing('flights', [
                'airline_id' => $flight['airline_id'],
                'departure_city_id' => $request['departure_city_id'],
                'arrival_city_id' => $flight['arrival_city_id'],
                'departure_date' => $flight['departure_date'],
                'arrival_date' => $flight['arrival_date'],
        ]);
    });

    it("cannot update flight's arrival city id that does not exist", function () {
        $flight = Flight::inRandomOrder()->firstOrFail();
        $arrival_city_id = -1;

        $request = [
            'arrival_city_id' => $arrival_city_id,
        ];

        $response = patchJson(url("/api/flights/$flight->id"), $request);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['arrival_city_id'], 'error.fields');
            
        assertDatabaseMissing('flights', [
                'airline_id' => $flight['airline_id'],
                'departure_city_id' => $flight['departure_city_id'],
                'arrival_city_id' => $request['arrival_city_id'],
                'departure_date' => $flight['departure_date'],
                'arrival_date' => $flight['arrival_date'],
        ]);
    });

    it("cannot update a flight's departure city that is not enabled by the airline", function () {
        $flight = Flight::inRandomOrder()->firstOrFail();
        $excluded_city_ids = $flight->airline->enabled_cities->pluck('id')
                ->merge([$flight->departure_city->id, $flight->arrival_city->id]);

        $departure_city = City::query()
            ->whereNotIn('id', $excluded_city_ids)
            ->inRandomOrder()
            ->firstOrFail();

        $request = [
            'departure_city_id' => $departure_city->id,
        ];

        $response = patchJson(url("/api/flights/$flight->id"), $request);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['airline_id'], 'error.fields');

        assertDatabaseMissing('flights', [
            'airline_id' => $flight['airline_id'],
            'departure_city_id' => $request['departure_city_id'],
            'arrival_city_id' => $flight['arrival_city_id'],
            'departure_date' => $flight['departure_date'],
            'arrival_date' => $flight['arrival_date'],
        ]);
    });

    it("cannot update a flight's arrival city that is not enabled by the airline", function () {
        $flight = Flight::inRandomOrder()->firstOrFail();
        $excluded_city_ids = $flight->airline->enabled_cities->pluck('id')
                ->merge([$flight->departure_city->id, $flight->arrival_city->id]);

        $arrival_city = City::query()
            ->whereNotIn('id', $excluded_city_ids)
            ->inRandomOrder()
            ->firstOrFail();
    
        $request = [
            'arrival_city_id' => $arrival_city->id,
        ];

        $response = patchJson(url("/api/flights/$flight->id"), $request);

        $response->assertUnprocessable()
        ->assertJsonValidationErrors(['airline_id'], 'error.fields');

        assertDatabaseMissing('flights', [
            'airline_id' => $flight['airline_id'],
            'departure_city_id' => $flight['departure_city_id'],
            'arrival_city_id' => $request['arrival_city_id'],
            'departure_date' => $flight['departure_date'],
            'arrival_date' => $flight['arrival_date'],
        ]);
    });
});
