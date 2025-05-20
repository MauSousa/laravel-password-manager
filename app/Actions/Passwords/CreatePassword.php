<?php

declare(strict_types=1);

namespace App\Actions\Passwords;

use App\Models\Password;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class CreatePassword
{
    /**
     * Create a new password for the user.
     *
     * @param  array<string, mixed>  $data
     */
    public function handle(array $data, User $user): Password
    {
        return $user->passwords()->create([
            'password' => Crypt::encryptString($data['password']),
            'url' => $data['url'],
            'username' => $data['username'],
        ]);
    }
}
