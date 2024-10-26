<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatriculadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Datos de ejemplo para los matriculados
        $matriculados = [
            [
                'nombres' => 'Juan',
                'apellidos' => 'Pérez',
                'dni' => '12345678',
                'registro_id' => 1, // Asegúrate de que este ID existe en la tabla registros
                'matricula_id' => 1, // Asegúrate de que este ID existe en la tabla matriculas
                'voucher_validado_id' => null, // Puedes usar un ID existente o dejarlo nulo
                'user_id' => 1, // Asegúrate de que este ID existe en la tabla users
            ],
            [
                'nombres' => 'María',
                'apellidos' => 'González',
                'dni' => '87654321',
                'registro_id' => 2,
                'matricula_id' => 2,
                'voucher_validado_id' => null,
                'user_id' => 2,
            ],
            [
                'nombres' => 'Carlos',
                'apellidos' => 'López',
                'dni' => '11223344',
                'registro_id' => 3,
                'matricula_id' => 1,
                'voucher_validado_id' => null,
                'user_id' => 3,
            ],
            [
                'nombres' => 'Ana',
                'apellidos' => 'Martínez',
                'dni' => '55667788',
                'registro_id' => 4,
                'matricula_id' => 2,
                'voucher_validado_id' => null,
                'user_id' => 4,
            ],
            [
                'nombres' => 'Pedro',
                'apellidos' => 'Sánchez',
                'dni' => '99887766',
                'registro_id' => 5,
                'matricula_id' => 1,
                'voucher_validado_id' => null,
                'user_id' => 5,
            ],
        ];

        // Insertar los datos en la tabla matriculados
        foreach ($matriculados as $matriculado) {
            DB::table('matriculados')->insert([
                'nombres' => $matriculado['nombres'],
                'apellidos' => $matriculado['apellidos'],
                'dni' => $matriculado['dni'],
                'registro_id' => $matriculado['registro_id'],
                'matricula_id' => $matriculado['matricula_id'],
                'voucher_validado_id' => $matriculado['voucher_validado_id'],
                'user_id' => $matriculado['user_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
