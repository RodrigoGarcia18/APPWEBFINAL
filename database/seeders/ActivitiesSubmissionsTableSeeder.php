<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesSubmissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los IDs de los estudiantes y actividades
        $studentIds = DB::table('students')->pluck('id')->toArray();
        $activityIds = DB::table('activities')->pluck('id')->toArray();

        foreach ($studentIds as $studentId) {
            // Asignar entre 1 y 3 actividades por estudiante
            $numberOfActivities = rand(1, 3);
            $assignedActivities = array_rand($activityIds, $numberOfActivities);

            // Asegurarse de que $assignedActivities sea un array
            if ($numberOfActivities === 1) {
                $assignedActivities = [$assignedActivities]; // Convertir a array si solo hay un índice
            }

            foreach ($assignedActivities as $activityKey) {
                $activityId = $activityIds[$activityKey];

                DB::table('activity_submissions')->insert([
                    'user_id' => $studentId,
                    'activity_id' => $activityId,
                    'filepath' => '', // Campo vacío por defecto
                    'text_content' => '', // Campo vacío por defecto
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
