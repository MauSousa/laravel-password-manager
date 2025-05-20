<?php

declare(strict_types=1);

namespace App\Actions\Passwords;

use App\Models\Password;
use Illuminate\Support\Facades\Crypt;

class UpdatePassword
{
    /**
     * Update the given password.
     *
     * @param  array<string, mixed>  $data
     */
    public function handle(Password $password, array $data): void
    {
        $password->update([
            // @phpstan-ignore-next-line
            'password' => Crypt::encryptString($data['password']) ?? $password->password,
            'username' => (string) ($data['username'] ?? $password->username),
            'url' => $data['url'] ?? $password->url,
        ]);

        $password->refresh();
    }
}
