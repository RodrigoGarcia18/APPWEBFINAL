<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function exportCourses()
    {
        // Obtener los cursos desde la base de datos
        $courses = Course::with('users')->get();

        // Definir el nombre del archivo
        $filename = 'cursos.csv';

        // Configurar las cabeceras para la descarga del archivo CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Abrir la salida de PHP como un flujo
        $output = fopen('php://output', 'w');

        // Escribir las cabeceras en el CSV
        fputcsv($output, ['ID', 'Nombre', 'Código de Curso', 'Periodo', 'Descripción', 'Usuarios Asignados']);

        // Escribir cada curso en una nueva línea del CSV
        foreach ($courses as $course) {
            fputcsv($output, [
                $course->id,
                $course->name,
                $course->course_id,
                $course->period,
                $course->description ?? 'No se proporcionó descripción',
                $course->users->count() > 0 ? implode(', ', $course->users->pluck('name')->toArray()) : 'Sin usuarios asignados',
            ]);
        }

        // Cerrar el flujo de salida
        fclose($output);
        exit();
    }

    public function exportUsers()
    {
        // Obtener los usuarios desde la base de datos
        $users = User::all();

        // Definir el nombre del archivo
        $filename = 'usuarios.csv';

        // Configurar las cabeceras para la descarga del archivo CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Abrir la salida de PHP como un flujo
        $output = fopen('php://output', 'w');

        // Escribir las cabeceras en el CSV
        fputcsv($output, ['ID', 'Nombre', 'Email', 'Rol', 'Código', 'DNI']);

        // Escribir cada usuario en una nueva línea del CSV
        foreach ($users as $user) {
            fputcsv($output, [
                $user->id,
                $user->name,
                $user->email,
                ucfirst($user->role),
                $user->codigo,
                $user->role === 'teacher' ? ($user->teacher->dni ?? 'N/A') : ($user->role === 'student' ? ($user->student->dni ?? 'N/A') : 'N/A'),
            ]);
        }

        // Cerrar el flujo de salida
        fclose($output);
        exit();
    }

    public function exportTeachers(){
        $teachers = User::where('role', 'teacher')->get();
        $filename = 'docentes.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Nombre', 'Email', 'Rol', 'Código', 'DNI']);
        foreach ($teachers as $teacher) {
            fputcsv($output, [
                $teacher->id,
                $teacher->name,
                $teacher->email,
                ucfirst($teacher->role),
                $teacher->codigo,
                $teacher->teacher->dni ?? 'N/A',
            ]);
        }
        fclose($output);
        exit();
    }

    public function exportStudents(){
        $students = User::where('role', 'student')->get();
        $filename = 'estudiantes.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Nombre', 'Email', 'Rol', 'Código', 'DNI']);
        foreach ($students as $student) {
            fputcsv($output, [
                $student->id,
                $student->name,
                $student->email,
                ucfirst($student->role),
                $student->codigo,
                $student->student->dni ?? 'N/A',
            ]);
        }
        fclose($output);
        exit();
    }
}
