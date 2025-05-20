<?php

declare(strict_types=1);

use App\Models\Password;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('to array', function () {
    $password = Password::factory()->create()->refresh();

    expect(array_keys($password->toArray()))
        ->toBe([
            'id',
            'user_id',
            'password',
            'url',
            'username',
            'created_at',
            'updated_at',
        ]);
});

test('password belongs to user', function () {
    $password = Password::factory()->create();

    expect($password->user)->toBeInstanceOf(User::class);
});

test('user has many passwords', function () {
    $user = User::factory()->create();
    Password::factory()->create(['user_id' => $user->id]);

    expect($user->passwords)->toHaveCount(1);
});
