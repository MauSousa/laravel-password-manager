<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Password;
use Illuminate\Database\Seeder;

class PasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Password::factory()->count(10)->create();
    }
}
