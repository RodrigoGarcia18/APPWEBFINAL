<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceTableSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los IDs de los estudiantes y cursos
        $studentIds = DB::table('students')->pluck('id')->toArray();
        $courseIds = DB::table('courses')->pluck('id')->toArray();

        // Definir un rango de fechas para la asistencia
        $startDate = Carbon::now()->subMonths(3); // Hace 3 meses
        $endDate = Carbon::now(); // Hasta hoy

        // Generar registros de asistencia
        foreach ($studentIds as $studentId) {
            // Generar asistencia para un número aleatorio de días
            $numberOfDays = rand(5, 10); // Generar asistencia para entre 5 y 10 días
            $dates = [];
            
            for ($i = 0; $i < $numberOfDays; $i++) {
                // Obtener una fecha aleatoria entre el rango
                $date = $startDate->copy()->addDays(rand(0, $endDate->diffInDays($startDate)));
                $dates[] = $date->toDateString();
            }

            foreach ($dates as $attendanceDate) {
                foreach ($courseIds as $courseId) {
                    DB::table('attendance')->insert([
                        'user_id' => $studentId,
                        'course_id' => $courseId,
                        'attendance_date' => $attendanceDate,
                        'status' => $this->getRandomStatus(), // Obtener un estado aleatorio
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    // Método para obtener un estado aleatorio de asistencia
    private function getRandomStatus(): string
    {
        $statuses = ['present', 'absent', 'late'];
        return $statuses[array_rand($statuses)];
    }
}
