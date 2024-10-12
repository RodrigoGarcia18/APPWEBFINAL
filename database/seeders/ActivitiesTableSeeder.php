<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $courses = DB::table('courses')->pluck('id')->toArray(); // Obtener todos los IDs de los cursos

        foreach ($courses as $courseId) {
            // Generar datos aleatorios para cada actividad
            $activityCode = 'ACT-' . strtoupper(uniqid()); // Código único para la actividad
            $activityName = 'Actividad para el Curso ' . $courseId; // Nombre de la actividad
            $activityDescription = 'Descripción de la actividad para el curso ' . $courseId; // Descripción
            $startDate = Carbon::now()->addDays(rand(1, 30)); // Fecha de inicio dentro de 1 a 30 días
            $endDate = Carbon::now()->addDays(rand(31, 60)); // Fecha de finalización dentro de 31 a 60 días

            DB::table('activities')->insert([
                'activity_code' => $activityCode,
                'name' => $activityName,
                'description' => $activityDescription,
                'course_id' => $courseId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
