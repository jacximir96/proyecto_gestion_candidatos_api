<?php

namespace Database\Seeders;

use App\Domain\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Opción para crear un usuario con rol manager
        User::factory()->create([
            'username' => 'tester',
            'role' => 'manager',
        ]);

        // Opción para crear un usuario con rol agent
        User::factory()->create([
            'username' => 'agent',
            'role' => 'agent',
        ]);

        // Crea otros usuarios aleatorios
        User::factory(10)->create();
    }
}
