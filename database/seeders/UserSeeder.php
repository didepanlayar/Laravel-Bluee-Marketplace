<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

use function Symfony\Component\Clock\now;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superuser = User::create([
            'name' => 'Superuser',
            'email' => 'superuser@bluee.com',
            'email_verified_at' => now(),
            'password' => bcrypt('Demo2025!'),
        ]);

        UserFactory::new()->count(15)->create();
    }
}
