<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organizations')->insert([
            [
                'name' => 'Organización Ejemplo',
                'description' => 'Esta es una organización dedicada a la educación y formación de estudiantes en diversas áreas.',
                'created_at' => now(), // Fecha de creación
                'updated_at' => now(), // Fecha de actualización
            ],
            [
                'name' => 'Fundación Aprender',
                'description' => 'Fundación sin fines de lucro que apoya a jóvenes en su desarrollo académico.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Asociación Educativa Avance',
                'description' => 'Asociación enfocada en la mejora continua de la educación en comunidades vulnerables.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
