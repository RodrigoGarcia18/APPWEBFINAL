<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Crea un usuario admin para todos los sistemas, como prueba
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@ejemplo.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);

        // Crea 2 profesores
        DB::table('users')->insert([
            ['name' => 'Profesor Uno', 'email' => 'profesor1@ejemplo.com', 'password' => bcrypt('password'), 'role' => 'teacher'],
            ['name' => 'Profesor Dos', 'email' => 'profesor2@ejemplo.com', 'password' => bcrypt('password'), 'role' => 'teacher'],
        ]);

        // Crea 30 estudiantes aleatorios
        for ($i = 1; $i <= 30; $i++) {  
            DB::table('users')->insert([
                'name' => 'Estudiante ' . $i,
                'email' => 'estudiante' . $i . '@ejemplo.com',
                'password' => bcrypt('password'),
                'role' => 'student',
            ]);
        }
    }
}
