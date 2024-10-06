<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Método para mostrar la vista del perfil del estudiante
    public function viewProfile()
    {
        return view('student.profile'); // Asegúrate de que esta vista exista
    }

    // Método para mostrar los cursos en los que está inscrito el estudiante
    public function viewCourses()
    {
        return view('student.courses'); // Asegúrate de que esta vista exista
    }

    // Método para mostrar las actividades del estudiante
    public function viewActivities()
    {
        return view('student.activities'); // Asegúrate de que esta vista exista
    }

    // Método para enviar una tarea
    public function submitAssignment(Request $request)
    {
        // Validación de datos
        $request->validate([
            'assignment' => 'required|file|mimes:pdf,doc,docx', // Cambia las reglas según tus necesidades
        ]);

        // Aquí agregarías la lógica para almacenar el archivo
        // $path = $request->file('assignment')->store('assignments');

        return redirect()->route('student.activities.view')->with('success', 'Tarea enviada correctamente.');
    }
}
