<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseUserTableSeeder extends Seeder
{
    public function run(): void
    {
        // Asumiendo que ya tienes los IDs de los estudiantes y cursos
        $studentIds = range(1, 30); // Estudiantes tienen ID del 1 al 30
        $courseIds = range(1, 15); // Cursos tienen ID del 1 al 15

        foreach ($studentIds as $studentId) {
            // Asignar de 3 a 4 cursos aleatorios a cada estudiante
            $assignedCourses = array_rand(array_flip($courseIds), rand(3, 4));
            foreach ($assignedCourses as $courseId) {
                DB::table('course_user')->insert([
                    'user_id' => $studentId, // ID del estudiante
                    'course_id' => $courseId, // ID del curso
                ]);
            }
        }
    }
}
