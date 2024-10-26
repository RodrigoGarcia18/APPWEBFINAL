<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CertificadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Instancia de Faker para generar datos aleatorios
        $faker = Faker::create();

        // Crear 10 certificados con datos aleatorios
        foreach (range(1, 10) as $index) {
            DB::table('certificados')->insert([
                'nombre' => 'Certificado ' . $index,
                'descripcion' => $faker->sentence(rand(5, 15)), // Descripción aleatoria
                'precio' => $faker->randomFloat(2, 10, 100), // Precio aleatorio entre 10.00 y 100.00
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
