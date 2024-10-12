<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeachersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Asume que ya se han creado los usuarios
        DB::table('teachers')->insert([
            [
                'user_id' => 2, // ID del primer profesor
                'first_name' => 'Juan',
                'last_name' => 'Pérez',
                'dni' => '12345678',
                'birth_date' => '1985-05-15',
                'subject' => 'Matemáticas',
                'address' => 'Calle Falsa 123',
                'phone' => '987654321',
                'profile_image' => null,
            ],
            [
                'user_id' => 3, // ID del segundo profesor
                'first_name' => 'Ana',
                'last_name' => 'Gómez',
                'dni' => '87654321',
                'birth_date' => '1990-08-25',
                'subject' => 'Historia',
                'address' => 'Avenida Siempre Viva 742',
                'phone' => '912345678',
                'profile_image' => null,
            ],
        ]);
    }
}
