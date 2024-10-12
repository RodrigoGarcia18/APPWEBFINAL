<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\ActivitySubmission;
use App\Models\Course;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    // Mostrar todas las actividades


    
    public function viewActivities(Request $request)
    {
        $user = Auth::user();
        $courses = $user->courses;
    
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
    
        // Filtra por nombre del docente si se proporciona
        if ($request->has('course_user') && $request->input('course_user') !== '') {
            $courses = $courses->filter(function ($course) use ($request) {
                return $course->teachers->contains(function ($user) use ($request) {
                    return stripos($user->name, $request->input('course_user')) !== false; // Filtra por el nombre del docente
                });
            });
        }
    
        // Filtra por periodo si se proporciona
        if ($request->has('course_period') && $request->input('course_period') !== '') {
            $courses = $courses->filter(function ($course) use ($request) {
                return $course->period === $request->input('course_period'); // Filtra por el periodo
            });
        }
    
        // Obtiene todas las actividades asignadas a los cursos del usuario
        $activities = Activity::whereIn('course_id', $courses->pluck('id'))->get();
    
        // Obtiene todos los periodos únicos
        $periods = Course::distinct()->pluck('period')->sort();
    
        // Cambia la vista a 'activities.index' y asegúrate de que estás pasando 'courses', 'periods' y 'activities'
        return view('activities.index', compact('courses', 'periods', 'activities'));
    }
    


    // Mostrar el formulario para crear una nueva actividad
    public function createActivity(Request $request)
    {
        // Obtener el ID del curso seleccionado desde la solicitud si está disponible
        $selectedCourseId = $request->input('course_id');
    
        // Obtener todos los cursos para el dropdown
        $courses = Course::all();
    
        // Inicializar el nombre del curso como null
        $selectedCourseName = null;
    
        // Si hay un ID de curso seleccionado, obtener el nombre del curso correspondiente
        if ($selectedCourseId) {
            $course = Course::find($selectedCourseId);
            $selectedCourseName = $course ? $course->name : null; // Obtener el nombre del curso si existe
        }
    
        return view('activities.create', compact('courses', 'selectedCourseId', 'selectedCourseName'));
    }
    
    // Almacenar una nueva actividad
    public function storeActivity(Request $request)
    {
        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'course_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
    
        // Crear la actividad
        $activity = Activity::create([
            'name' => $request->name,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            // 'activity_code' no es necesario aquí, se generará automáticamente
        ]);
    
        // Redirigir a la lista de actividades con un mensaje de éxito
        return redirect()->route('teacher.activities.view')->with('success', 'Actividad creada con éxito.');
    }
    
    
    

    // Mostrar los detalles de una actividad
    public function showActivity($id)
    {
        $activity = Activity::with('course')->findOrFail($id); // Obtener la actividad con su curso
        $submission = ActivitySubmission::where('user_id', Auth::id()) // Cambia auth()->id() a Auth::id()
            ->where('activity_id', $activity->id)
            ->first(); // Obtener la sumisión del usuario para esta actividad
    
        return view('activities.show', compact('activity', 'submission'));
    }
    

    // Mostrar el formulario para editar una actividad
    public function editActivity($id)
    {
        // Buscar la actividad por su ID y obtener todos los cursos disponibles
        $activity = Activity::findOrFail($id);
        $courses = Course::all(); // Obtener todos los cursos para el formulario
    
        return view('activities.edit', compact('activity', 'courses'));
    }

    // Actualizar una actividad existente
    public function updateActivity(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
    
        $activity = Activity::findOrFail($id);
        $activity->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    
        return redirect()->route('teacher.activities.view')->with('success', 'Actividad actualizada con éxito.');
    }
    

    // Eliminar una actividad
    public function destroyActivity($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->route('teacher.activities.view')->with('success', 'Actividad eliminada con éxito.');
    }
}
