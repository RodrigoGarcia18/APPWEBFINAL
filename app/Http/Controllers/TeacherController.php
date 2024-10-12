<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; // Importa la fachada Auth
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Nota;
use App\Models\ActivitySubmission;
use App\Models\Student;
use App\Models\Activity; // Asegúrate de importar el modelo Activity

class TeacherController extends Controller
{


    public function dashboard()
    {
        return view('teacher.dashboard');
    }

    public function viewCourses(Request $request)
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

        // Obtiene todos los periodos únicos
        $periods = Course::distinct()->pluck('period')->sort();

        return view('teacher.courses.courses', compact('courses', 'periods'));
    }

    public function getStudentsByCourse($courseId)
    {
        // Obtener los estudiantes asignados al curso
        $students = User::whereHas('courses', function ($query) use ($courseId) {
            $query->where('courses.id', $courseId);
        })->get();

        return response()->json($students);
    }

    public function showCourseDetails($id)
    {
        $course = Course::with('users')->find($id);
        if (!$course) {
            return redirect()->route('teacher.courses.view')->with('error', 'Curso no encontrado.');
        }

        return view('teacher.courses.details', compact('course'));
    }

    public function updateSessionLink(Request $request, $id)
    {
        // Validar el input
        $request->validate([
            'session_link' => 'required|url', // Asegúrate de validar que es una URL
        ]);

        // Encontrar el curso por su ID
        $course = Course::findOrFail($id);

        // Actualizar el enlace de la sesión
        $course->session_link = $request->input('session_link');
        $course->save();

        // Redirigir de vuelta a los detalles del curso con un mensaje de éxito
        return redirect()->route('teacher.courses.details', $course->id)->with('success', 'Enlace de sesión actualizado exitosamente.');
    }

    // Método para mostrar la lista de actividades
     public function editActivity($courseId, $activityId)
    {
        $activity = Activity::findOrFail($activityId);
        return view('teacher.activities.edit', compact('activity', 'courseId'));
    }

    // Método para actualizar una actividad existente
    public function updateActivity(Request $request, $courseId, $activityId)
    {
        // Validación de datos
        $request->validate([
            'activity_code' => 'required|max:255|unique:activities,activity_code,' . $activityId,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Actualizar la actividad
        $activity = Activity::findOrFail($activityId);
        $activity->update([
            'activity_code' => $request->activity_code,
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('teacher.activities.view', $courseId)->with('success', 'Actividad actualizada correctamente.');
    }

    // Método para mostrar la lista de actividades
    public function viewActivities($courseId)
    {
        $activities = Activity::where('course_id', $courseId)->get();
        return view('teacher.activities', compact('activities', 'courseId')); // Asegúrate de pasar $courseId
    }

    // Método para mostrar el formulario de creación de actividad
    public function createActivity($courseId)
    {
        return view('teacher.activities.create', compact('courseId'));
    }

    // Método para almacenar una nueva actividad
    public function storeActivity(Request $request, $courseId)
    {
        // Validación de datos
        $request->validate([
            'activity_code' => 'required|unique:activities|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Crear la actividad
        Activity::create([
            'activity_code' => $request->activity_code,
            'name' => $request->name,
            'description' => $request->description,
            'course_id' => $courseId,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('teacher.activities.view', $courseId)->with('success', 'Actividad creada correctamente.');
    }

    // Método para mostrar las notas
    public function viewGrades()
    {
        // Obtén el usuario autenticado
        $user = Auth::user();
        
        // Obtén los cursos asignados a este usuario
        $courses = $user->courses; // Esto obtiene los cursos relacionados
    
        return view('grades.index', compact('courses'));
    }
    
    public function viewSubmissions($activityId)
    {
        // Obtén la actividad y sus entregas, incluyendo el usuario asociado
        $activity = Activity::with('submissions.user')->findOrFail($activityId);
        
        return view('grades.submissions', compact('activity'));
    }
    

    public function storeGrade(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'activity_submission_id' => 'required|exists:activity_submissions,id', // Verifica que la actividad exista
            'nota' => 'required|numeric|min:0|max:100', // La nota debe ser un número entre 0 y 100
        ]);
    
        // Evitar la duplicación de notas
        $existingNota = Nota::where('activity_submission_id', $request->activity_submission_id)->first();
    
        if ($existingNota) {
            return redirect()->back()->withErrors(['error' => 'Ya se ha asignado una nota para esta actividad.']);
        }
    
        // Guardar la nota en la base de datos
        Nota::create([
            'activity_submission_id' => $request->activity_submission_id,
            'nota' => $request->nota,
        ]);
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('teacher.grades.view')->with('success', 'Nota asignada correctamente.');
    }
    
    public function updateGrades(Request $request)
    {
        $submissions = $request->input('submissions', []);
    
        foreach ($submissions as $submissionData) {
            // Validar las entradas
            $request->validate([
                'submissions.*.activity_submission_id' => 'required|exists:activity_submissions,id',
                'submissions.*.nota' => 'required|numeric|min:0|max:100',
            ]);
    
            // Buscar la nota correspondiente a la entrega
            $nota = Nota::where('activity_submission_id', $submissionData['activity_submission_id'])->first();
    
            if ($nota) {
                // Si ya existe, actualiza la nota
                $nota->update([
                    'nota' => $submissionData['nota'],
                ]);
            } else {
                // Si no existe, crear una nueva nota
                Nota::create([
                    'activity_submission_id' => $submissionData['activity_submission_id'],
                    'nota' => $submissionData['nota'],
                ]);
            }
        }
    
        return redirect()->route('teacher.grades.view')->with('success', 'Notas actualizadas correctamente.');
    }
    


}
