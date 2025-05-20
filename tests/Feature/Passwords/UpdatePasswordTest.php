<?php

declare(strict_types=1);

use App\Models\Password;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can update the password', function () {
    $user = User::factory()->create();
    $password = Password::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->patch(route('passwords.update', $password), [
        'password' => 'Moonrise5-Deplete8-Crawfish4-Chihuahua4-Visor3-Laziness3-Semisweet6-Hurled6-Upcoming0-Rework6',
        'url' => 'https://example.com',
        'username' => 'username',
    ]);

    $response->assertRedirect(route('passwords.edit', $password));

    $this->assertDatabaseHas('passwords', [
        'user_id' => $user->id,
        'url' => 'https://example.com',
        'username' => 'username',
    ]);
});

test('can not update the password if the url is not unique', function () {
    $user = User::factory()->create();
    $password = Password::factory()->create([
        'user_id' => $user->id,
        'url' => 'https://example.com',
    ]);
    $password2 = Password::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->patch(route('passwords.update', $password2), [
        'password' => 'Moonrise5-Deplete8-Crawfish4-Chihuahua4-Visor3-Laziness3-Semisweet6-Hurled6-Upcoming0-Rework6',
        'url' => 'https://example.com',
        'username' => 'username',
    ]);

    $response->assertSessionHasErrors('url');
});
