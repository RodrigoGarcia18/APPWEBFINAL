<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Http;
use App\Models\ActivitySubmission;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Nota;
use App\Models\Activity;

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


        foreach ($courses as $course) {
            $course->teachers = $course->users->filter(function ($user) {
                return $user->role === 'teacher';
            });
        }


        if ($request->has('name') && $request->input('name') !== '') {
            $courses = $courses->filter(function ($course) use ($request) {
                return stripos($course->name, $request->input('name')) !== false; // Filtra por el nombre del curso
            });
        }


        if ($request->has('course_user') && $request->input('course_user') !== '') {
            $courses = $courses->filter(function ($course) use ($request) {
                return $course->teachers->contains(function ($user) use ($request) {
                    return stripos($user->name, $request->input('course_user')) !== false; // Filtra por el nombre del docente
                });
            });
        }


        if ($request->has('course_period') && $request->input('course_period') !== '') {
            $courses = $courses->filter(function ($course) use ($request) {
                return $course->period === $request->input('course_period');
            });
        }


        $periods = Course::distinct()->pluck('period')->sort();

        return view('teacher.courses.courses', compact('courses', 'periods'));
    }

    public function getStudentsByCourse($courseId)
    {

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

        $request->validate([
            'session_link' => 'required|url',
        ]);


        $course = Course::findOrFail($id);


        $course->session_link = $request->input('session_link');
        $course->save();


        return redirect()->route('teacher.courses.details', $course->id)->with('success', 'Enlace de sesión actualizado exitosamente.');
    }

    public function updateMaterialLink(Request $request, $id)
    {

        $request->validate([
            'material_link' => 'required|url',
        ]);


        $course = Course::findOrFail($id);


        $course->material_link = $request->input('material-link');
        $course->save();


        return redirect()->route('teacher.courses.details', $course->id)->with('success', 'Enlace del material actualizado exitosamente.');
    }


     public function editActivity($courseId, $activityId)
    {
        $activity = Activity::findOrFail($activityId);
        return view('teacher.activities.edit', compact('activity', 'courseId'));
    }


    public function updateActivity(Request $request, $courseId, $activityId)
    {

        $request->validate([
            'activity_code' => 'required|max:255|unique:activities,activity_code,' . $activityId,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);


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


    public function viewActivities($courseId)
    {
        $activities = Activity::where('course_id', $courseId)->get();
        return view('teacher.activities', compact('activities', 'courseId')); // Asegúrate de pasar $courseId
    }


    public function createActivity($courseId)
    {
        return view('teacher.activities.create', compact('courseId'));
    }


    public function storeActivity(Request $request, $courseId)
    {

        $request->validate([
            'activity_code' => 'required|unique:activities|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);


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


    public function viewGrades()
    {

        $user = Auth::user();


        $courses = $user->courses;

        return view('grades.index', compact('courses'));
    }

    public function viewSubmissions($activityId)
    {

        $activity = Activity::with('submissions.user')->findOrFail($activityId);

        return view('grades.submissions', compact('activity'));
    }


    public function storeGrade(Request $request)
    {

        $request->validate([
            'activity_submission_id' => 'required|exists:activity_submissions,id',
            'nota' => 'required|numeric|min:0|max:100',
        ]);


        $existingNota = Nota::where('activity_submission_id', $request->activity_submission_id)->first();

        if ($existingNota) {
            return redirect()->back()->withErrors(['error' => 'Ya se ha asignado una nota para esta actividad.']);
        }


        Nota::create([
            'activity_submission_id' => $request->activity_submission_id,
            'nota' => $request->nota,
        ]);


        return redirect()->route('teacher.grades.view')->with('success', 'Nota asignada correctamente.');
    }

    public function updateGrades(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'submissions.*.activity_submission_id' => 'required|exists:activity_submissions,id',
            'submissions.*.nota' => 'required|numeric|min:0|max:100',
        ]);

        $submissions = $request->input('submissions', []);

        foreach ($submissions as $submissionData) {
            // Buscar o crear la nota
            $nota = Nota::where('activity_submission_id', $submissionData['activity_submission_id'])->first();

            if ($nota) {
                // Actualizar nota existente
                $nota->update([
                    'nota' => $submissionData['nota'],
                ]);
            } else {
                // Crear una nueva nota
                Nota::create([
                    'activity_submission_id' => $submissionData['activity_submission_id'],
                    'nota' => $submissionData['nota'],
                ]);
            }

            // Obtener la actividad y el curso relacionado
            $activitySubmission = ActivitySubmission::find($submissionData['activity_submission_id']);
            $activity = $activitySubmission->activity; 
            $course = $activity->course;

            // Obtener el estudiante asociado a la entrega
            $student = $activitySubmission->user;

            // Verificar si el usuario es un estudiante
            if ($student && $student->isStudent()) {
                // Enviar notificación al microservicio
                try {
                    $response = Http::post('http://35.224.43.49:8087/api/send-notification', [
                        'email' => $student->email,
                        'subject' => 'La Nota Ha Sido Actualizada',
                        'message' => 'Se ha actualizado la nota para la actividad: ' . $activity->name .
                                     ' del curso: ' . $course->name .
                                     '. Tu nueva calificación es: ' . $submissionData['nota'],
                    ]);

                    // Verificar respuesta del microservicio
                    if (!$response->successful()) {
                        return redirect()->route('teacher.grades.view')
                            ->with('error', 'No se pudo enviar la notificación a uno de los estudiantes.');
                    }
                } catch (\Exception $e) {
                    return redirect()->route('teacher.grades.view')
                        ->with('error', 'Error al conectar con el microservicio de notificaciones.');
                }
            }
        }

        return redirect()->route('teacher.grades.view')->with('success', 'Notas actualizadas correctamente.');
    }
    



}
