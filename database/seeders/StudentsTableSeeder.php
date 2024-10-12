<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
            DB::table('students')->insert([
                'user_id' => $i + 3, // Asegúrate de ajustar el ID correctamente
                'first_name' => 'Estudiante ' . $i,
                'last_name' => 'Apellido ' . $i,
                'dni' => 'DNI' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'birth_date' => '2000-01-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'enrollment_number' => 'MATRICULA' . $i,
                'address' => 'Dirección ' . $i,
                'phone' => '90000000' . $i,
                'profile_image' => null,
            ]);
        }
    }
}
