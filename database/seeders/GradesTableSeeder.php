<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los IDs de las entregas de actividades
        $activitySubmissionIds = DB::table('activity_submissions')->pluck('id')->toArray();

        foreach ($activitySubmissionIds as $submissionId) {
            DB::table('notas')->insert([
                'activity_submission_id' => $submissionId,
                'nota' => round(rand(50, 100) / 10, 1), // Generar una nota aleatoria entre 5.0 y 10.0
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
