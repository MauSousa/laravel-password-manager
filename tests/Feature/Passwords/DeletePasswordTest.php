<?php

declare(strict_types=1);

use App\Models\Password;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can delete the password', function () {
    $user = User::factory()->create();
    $password = Password::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->delete(route('passwords.destroy', $password));

    $response->assertRedirect(route('dashboard'));
});
