<?php

declare(strict_types=1);

namespace App\Actions\Passwords;

use App\Models\Password;

class DeletePassword
{
    /**
     * Delete the given password.
     */
    public function handle(Password $password): void
    {
        $password->delete();
    }
}
