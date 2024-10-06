<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // Método para mostrar el dashboard del docente
    public function dashboard()
    {
        return view('teacher.dashboard');
    }

    // Método para mostrar la lista de cursos
    public function viewCourses()
    {
        return view('teacher.courses');
    }

    // Método para mostrar la lista de actividades
    public function viewActivities()
    {
        return view('teacher.activities');
    }

    // Método para mostrar el formulario de creación de actividad
    public function createActivity()
    {
        return view('teacher.create_activity'); // Asegúrate de que esta vista exista
    }

    // Método para almacenar una nueva actividad
    public function storeActivity(Request $request)
    {
        // Validación de datos (puedes agregar más reglas)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Aquí podrías agregar lógica para guardar la actividad en la base de datos
        // Activity::create([...]);

        return redirect()->route('teacher.activities.view')->with('success', 'Actividad creada correctamente.');
    }

    // Método para mostrar las notas
    public function viewGrades()
    {
        return view('teacher.grades');
    }
}
