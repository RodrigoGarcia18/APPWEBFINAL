<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RegistrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Generar registros de estudiantes
        for ($i = 0; $i < 50; $i++) { // Generar 50 registros de ejemplo
            DB::table('registros')->insert([
                'nombres' => $this->getRandomName(), // Nombre aleatorio
                'apellidos' => $this->getRandomLastName(), // Apellido aleatorio
                'dni' => $this->generateDNI(), // Generar un código de DNI único
                'celular' => $this->generateCelular(), // Generar un número de celular aleatorio
                'edad' => rand(18, 30), // Edad aleatoria entre 18 y 30
                'sexo' => $this->getRandomSexo(), // Sexo aleatorio
                'fecha_nacimiento' => Carbon::now()->subYears(rand(18, 30)), // Fecha de nacimiento aleatoria
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // Método para generar un código de DNI aleatorio
    private function generateDNI(): string
    {
        return str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT); // Generar un DNI de 8 dígitos
    }

    // Método para generar un número de celular aleatorio
    private function generateCelular(): string
    {
        $prefix = '9'; // Prefijo común para números de celular en algunos países
        return $prefix . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT); // Generar un número de celular de 9 dígitos
    }

    // Método para obtener un nombre aleatorio
    private function getRandomName(): string
    {
        $names = ['Juan', 'María', 'Pedro', 'Luisa', 'Carlos', 'Ana', 'Jorge', 'Isabel'];
        return $names[array_rand($names)];
    }

    // Método para obtener un apellido aleatorio
    private function getRandomLastName(): string
    {
        $lastNames = ['García', 'Martínez', 'López', 'Hernández', 'Pérez', 'González'];
        return $lastNames[array_rand($lastNames)];
    }

    // Método para obtener un sexo aleatorio
    private function getRandomSexo(): string
    {
        $sexos = ['Masculino', 'Femenino'];
        return $sexos[array_rand($sexos)];
    }
}
