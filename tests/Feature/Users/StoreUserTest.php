<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use Database\Factories\UserFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\Fluent\AssertableJson;
use Lightit\Backoffice\Users\App\Controllers\StoreUserController;
use Lightit\Backoffice\Users\App\Notifications\UserRegistered;
use Lightit\Backoffice\Users\App\Transformers\UserTransformer;
use Lightit\Backoffice\Users\Domain\Models\User;
use Tests\RequestFactories\StoreUserRequestFactory;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\postJson;

beforeEach(fn () => Notification::fake());

describe('users', function () {
    /** @see StoreUserController */
    it('can create a user successfully', function () {
        $data = StoreUserRequestFactory::new()->create([
            'password' => 'passw0rd',
        ]);

        $response = postJson(url('/api/users'), $data);

        $user = User::query()
            ->where('email', $data['email'])
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
                            transformation($user, UserTransformer::class)->transform() ?? []
                        )
                    )
            );

        assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        expect(Hash::check('passw0rd', $user->password))->toBeTrue();

        Notification::assertSentTo($user, UserRegistered::class);
    });

    it('cannot create a user with an already registered email', function () {
        $existingUser = UserFactory::new()->createOne();

        $data = StoreUserRequestFactory::new()->create([
            'email' => $existingUser->email,
        ]);

        $response = postJson(url('/api/users'), $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['email'], 'error.fields');

        assertDatabaseMissing('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    });

    it('cannot create a user with invalid data', function () {
        $data = [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
        ];

        $response = postJson(url('/api/users'), $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'password'], 'error.fields');
    });

    it('triggers user registration notification', function () {
        Notification::fake();

        $data = StoreUserRequestFactory::new()->create();

        postJson(url('/api/users'), $data);

        $user = User::query()->where('email', $data['email'])->firstOrFail();

        Notification::assertSentTo($user, UserRegistered::class);
    });
});
