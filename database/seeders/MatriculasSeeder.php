<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatriculasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Datos de ejemplo para las matrículas
        $matriculas = [
            [
                'nombre' => 'Curso de Programación PHP',
                'descripcion' => 'Aprende a desarrollar aplicaciones web con PHP.',
                'precio' => 150.00,
            ],
            [
                'nombre' => 'Curso de Diseño Gráfico',
                'descripcion' => 'Conviértete en un experto en diseño gráfico y edición de imágenes.',
                'precio' => 200.00,
            ],
            [
                'nombre' => 'Curso de Marketing Digital',
                'descripcion' => 'Domina las estrategias de marketing en línea y redes sociales.',
                'precio' => 120.00,
            ],
            [
                'nombre' => 'Curso de Fotografía',
                'descripcion' => 'Aprende las técnicas de fotografía profesional.',
                'precio' => 180.00,
            ],
            [
                'nombre' => 'Curso de Desarrollo Web',
                'descripcion' => 'Crea sitios web responsivos y funcionales desde cero.',
                'precio' => 220.00,
            ],
            [
                'nombre' => 'Curso de Excel Avanzado',
                'descripcion' => 'Mejora tus habilidades en Excel con técnicas avanzadas.',
                'precio' => 90.00,
            ],
        ];

        // Insertar los datos en la tabla matriculas
        foreach ($matriculas as $matricula) {
            DB::table('matriculas')->insert([
                'nombre' => $matricula['nombre'],
                'descripcion' => $matricula['descripcion'],
                'precio' => $matricula['precio'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
