<?php

declare(strict_types=1);

use App\Models\Password;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can store a new password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/passwords', [
        'password' => 'Moonrise5-Deplete8-Crawfish4-Chihuahua4-Visor3-Laziness3-Semisweet6-Hurled6-Upcoming0-Rework6',
        'url' => 'https://example.com',
        'username' => 'username',
    ]);

    $response->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('passwords', [
        'user_id' => $user->id,
        'url' => 'https://example.com',
        'username' => 'username',
    ]);
});

test('can not store a new password if the url is not unique', function () {
    $user = User::factory()->create();
    Password::factory()->create([
        'user_id' => $user->id,
        'url' => 'https://example.com',
    ]);

    $response = $this->actingAs($user)->post('/passwords', [
        'password' => 'Moonrise5-Deplete8-Crawfish4-Chihuahua4-Visor3-Laziness3-Semisweet6-Hurled6-Upcoming0-Rework6',
        'url' => 'https://example.com',
        'username' => 'username',
    ]);

    $response->assertSessionHasErrors('url');
});

test('can not store new password if password is not valid', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/passwords', [
        'password' => 'pass',
        'url' => 'https://example.com',
        'username' => 'username',
    ]);

    $response->assertSessionHasErrors('password');
});

test('can not store new password if password is not provided', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/passwords', [
        'url' => 'https://example.com',
        'username' => 'username',
    ]);

    $response->assertSessionHasErrors('password');
});
