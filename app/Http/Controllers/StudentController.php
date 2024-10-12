<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Activity;


class StudentController extends Controller
{
    // Método para mostrar la vista del perfil del estudiante
    public function viewProfile()
    {
        return view('student.profile'); // Asegúrate de que esta vista exista
    }

    // Método para mostrar los cursos en los que está inscrito el estudiante
    public function viewCourses(Request $request)
    {
        // Obtiene el usuario autenticado
        $user = Auth::user();
        
        // Obtiene los cursos del estudiante
        $courses = $user->courses; // Mantenemos esta parte tal como está
    
        // Filtra los usuarios que son teachers solo al mostrar en la vista
        foreach ($courses as $course) {
            $course->teachers = $course->users->filter(function ($user) {
                return $user->role === 'teacher'; // Verifica si el rol es 'teacher'
            });
        }
    
        // Filtra por nombre de curso si se proporciona
        if ($request->has('name') && $request->input('name') !== '') {
            $courses = $courses->filter(function ($course) use ($request) {
                return stripos($course->name, $request->input('name')) !== false; // Filtra por el nombre del curso
            });
        }
    
        // Filtra por periodo si se proporciona
        if ($request->has('course_period') && $request->input('course_period') !== '') {
            $courses = $courses->filter(function ($course) use ($request) {
                return $course->period === $request->input('course_period'); // Filtra por el periodo
            });
        }
    
        // Obtiene todos los periodos únicos
        $periods = Course::distinct()->pluck('period')->sort();
    
        return view('student.courses', compact('courses', 'periods'));
    }
    
    
    
    

    public function showCourseDetails($id)
    {
        // Encuentra el curso por su ID y carga los usuarios y actividades
        $course = Course::with(['users', 'activities'])->findOrFail($id); // Carga también los usuarios y actividades
    
        // Filtrar docentes
        $teachers = $course->users->filter(function($user) {
            return $user->role === 'teacher'; // Filtrar solo los docentes
        });
    
        // Obtener actividades del curso
        $activities = $course->activities;
    
        // Pasar las variables a la vista
        return view('student.details', compact('course', 'teachers', 'activities'));
    }
    
    
    
    // Método para mostrar las actividades del estudiante
    public function viewActivities(Request $request)
    {
        $user = Auth::user();
        
        // Obtiene los cursos del estudiante
        $courses = $user->courses; // Mantenemos esta parte tal como está
    
        // Carga las actividades y las entregas con sus notas relacionadas para los cursos
        $courses->load(['activities.submissions.nota']); 
    
        // Filtra los usuarios que son teachers solo al mostrar en la vista
        foreach ($courses as $course) {
            $course->teachers = $course->users->filter(function ($user) {
                return $user->role === 'teacher'; // Verifica si el rol es 'teacher'
            });
        }
        
        // Filtra por nombre de curso si se proporciona
        if ($request->has('name') && $request->input('name') !== '') {
            $courses = $courses->filter(function ($course) use ($request) {
                return stripos($course->name, $request->input('name')) !== false; // Filtra por el nombre del curso
            });
        }
        
        // Filtra por periodo si se proporciona
        if ($request->has('course_period') && $request->input('course_period') !== '') {
            $courses = $courses->filter(function ($course) use ($request) {
                return $course->period === $request->input('course_period'); // Filtra por el periodo
            });
        }
        
        // Obtiene todos los periodos únicos
        $periods = Course::distinct()->pluck('period')->sort(); 
    
        return view('student.activities', compact('courses', 'periods'));
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

        return redirect()->route('student.activities')->with('success', 'Tarea enviada correctamente.');
    }
}
