<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario Administrador por defecto
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@cafeteria.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Usuario Empleado de prueba
        User::factory()->create([
            'name' => 'Empleado',
            'email' => 'empleado@cafeteria.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
        ]);
    }
}
