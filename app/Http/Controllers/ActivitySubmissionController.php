<?php

namespace App\Http\Controllers;

use App\Models\ActivitySubmission;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PHPMailer\PHPMailer\PHPMailer;
class ActivitySubmissionController extends Controller
{

    public function create($activityId)
    {
        $activity = Activity::findOrFail($activityId);
        $course = Course::findOrFail($activity->course_id);

        return view('activity_submissions.create', compact('activity', 'course'));
    }



    public function store(Request $request, $activityId)
    {
        // Validar la solicitud
        $request->validate([
            'text_content' => 'nullable|string',
            'filepath' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Guardar la entrega de la actividad
        $submission = new ActivitySubmission();
        $submission->activity_id = $activityId;
        $submission->user_id = $user->id;
        $submission->text_content = $request->text_content;

        if ($request->hasFile('filepath')) {
            $submission->filepath = $request->file('filepath')->store('uploads', 'public');
        }

        $submission->save();

        // Obtener la actividad y verificar que exista
        $activity = Activity::find($activityId);
        if (!$activity) {
            return redirect()->route('student.courses.view')->with('error', 'Actividad no encontrada.');
        }

        // Obtener el curso y verificar que exista
        $curso = $activity->course;
        if (!$curso) {
            return redirect()->route('student.courses.view')->with('error', 'Curso no encontrado.');
        }

        // Obtener al profesor asignado al curso
        $teacher = $curso->users()->where('role', 'teacher')->first();

        if ($teacher) {
            // Enviar notificación al microservicio
            try {
                $response = Http::post('http://microservicio-notificaciones/api/send-notification', [
                    'email' => $teacher->email, 
                    'subject' => 'Han subido una nueva actividad', // Asunto del correo
                    'message' => 'El estudiante ' . $user->name . ' ha subido una actividad en el curso: ' . $curso->name, // Mensaje
                ]);

                // Verificar si el microservicio respondió exitosamente
                if ($response->successful()) {
                    return redirect()->route('student.courses.view')->with('success', 'Actividad enviada y notificación enviada al profesor.');
                } else {
                    return redirect()->route('student.courses.view')->with('error', 'No se pudo enviar la notificación al profesor.');
                }
            } catch (\Exception $e) {
                return redirect()->route('student.courses.view')->with('error', 'Error al conectar con el microservicio de notificaciones.');
            }
        } else {
            return redirect()->route('student.courses.view')->with('error', 'No se ha asignado ningún profesor a este curso.');
        }
    }
    
}
