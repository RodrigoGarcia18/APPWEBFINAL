<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Array de cursos para insertar en la base de datos
        $courses = [
            [
                'course_id' => 'C001',
                'name' => 'Matemáticas I',
                'period' => '2024-1',
                'session_link' => 'https://link-a-sesion-1.com',
                'description' => 'Curso introductorio a las matemáticas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C002',
                'name' => 'Física I',
                'period' => '2024-1',
                'session_link' => 'https://link-a-sesion-2.com',
                'description' => 'Fundamentos de la física para estudiantes de primer año.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C003',
                'name' => 'Química General',
                'period' => '2024-1',
                'session_link' => 'https://link-a-sesion-3.com',
                'description' => 'Introducción a los conceptos básicos de la química.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C004',
                'name' => 'Programación Básica',
                'period' => '2024-1',
                'session_link' => 'https://link-a-sesion-4.com',
                'description' => 'Curso básico de programación en Python.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C005',
                'name' => 'Literatura Española',
                'period' => '2024-1',
                'session_link' => 'https://link-a-sesion-5.com',
                'description' => 'Análisis de obras clásicas de la literatura española.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C006',
                'name' => 'Historia del Arte',
                'period' => '2024-1',
                'session_link' => 'https://link-a-sesion-6.com',
                'description' => 'Estudio de las diferentes corrientes artísticas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C007',
                'name' => 'Biología Celular',
                'period' => '2024-1',
                'session_link' => 'https://link-a-sesion-7.com',
                'description' => 'Introducción a la biología y sus fundamentos celulares.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C008',
                'name' => 'Economía Básica',
                'period' => '2024-1',
                'session_link' => 'https://link-a-sesion-8.com',
                'description' => 'Principios fundamentales de la economía.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C009',
                'name' => 'Filosofía Moderna',
                'period' => '2024-1',
                'session_link' => 'https://link-a-sesion-9.com',
                'description' => 'Análisis de las teorías filosóficas modernas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C010',
                'name' => 'Sociología Contemporánea',
                'period' => '2024-1',
                'session_link' => 'https://link-a-sesion-10.com',
                'description' => 'Estudio de la sociedad y sus estructuras contemporáneas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C011',
                'name' => 'Matemáticas II',
                'period' => '2024-2',
                'session_link' => 'https://link-a-sesion-11.com',
                'description' => 'Continuación de Matemáticas I.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C012',
                'name' => 'Física II',
                'period' => '2024-2',
                'session_link' => 'https://link-a-sesion-12.com',
                'description' => 'Continuación de Física I.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C013',
                'name' => 'Química Orgánica',
                'period' => '2024-2',
                'session_link' => 'https://link-a-sesion-13.com',
                'description' => 'Estudio de compuestos orgánicos y sus reacciones.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C014',
                'name' => 'Programación Avanzada',
                'period' => '2024-2',
                'session_link' => 'https://link-a-sesion-14.com',
                'description' => 'Curso avanzado de programación en C++.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 'C015',
                'name' => 'Gestión de Proyectos',
                'period' => '2024-2',
                'session_link' => 'https://link-a-sesion-15.com',
                'description' => 'Fundamentos en la gestión de proyectos y planificación.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insertar cursos en la base de datos
        DB::table('courses')->insert($courses);
    }
}
