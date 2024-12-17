<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use OpenAdmin\Admin\Grid\Filter\Where;
use PHPMailer\PHPMailer\PHPMailer;
class CourseController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $courses = $user->organization ? $user->organization->courses : collect();
        return view('admin.courses.index', compact('courses'));
    }


    public function viewCourses(Request $request)
    {
        $query = Course::with('teacher');

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $courses = $query->get();

        return view('admin.courses.index', compact('courses'));
    }




    public function createCourse()
    {

        $users = User::where('role', 'teacher')->get();

        return view('admin.courses.create', compact('users'));
    }


    public function storeCourse(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|string|max:100|unique:courses,course_id',
            'description' => 'nullable|string|max:500',
            'period' => 'required|string|max:100',
            'precio' => 'nullable|numeric|min:0|max:999999.99',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $course = Course::create([
            'name' => $request->name,
            'course_id' => $request->course_id,
            'description' => $request->description,
            'period' => $request->period,
            'precio' => $request->precio,
            // Agrega el enlace de la sesión con la url del host mas el nombre del curso
            'session_link' => url("/meet/{$request->course_id}"),
        ]);

        $teacher = $course->users()->where('role', 'teacher')->first();

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = 'tls';
        $mail->Port = env('MAIL_PORT');

        $mail->setFrom('admin@learnhub.com', 'Mailer');
        $mail->addAddress('e70205523@gmail.com', 'Receiver');
        //$mail->addAddress($teacher->email, 'Receiver');

        $mail->Subject = 'Nuevo Curso Asignado';
        $mail->Body = 'Tienes un nuevo curso asignado: ' . $course->name;

        $mail->send();

        return redirect()->route('admin.courses.view')->with('success', 'Curso creado exitosamente.');
    }

    public function StartMeeting($courseId)
    {
        $course = Course::where('course_id', $courseId)->first();
        if (!$course) { // Si no se encuentra el curso.
            abort(404, 'El curso no existe.'); // Lanza un error 404 con un mensaje.

        }
        return view('meet.start');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $users = User::where('role', 'teacher')->get();

        return view('admin.courses.edit', compact('course', 'users'));
    }



    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'course_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'precio' => 'nullable|numeric|min:0|max:999999.99',
            'description' => 'nullable|string',
            'user_ids' => 'required|array',
        ]);

        $course = Course::findOrFail($id);
        $course->update($validatedData);


        $course->users()->sync($request->user_ids);

        return redirect()->route('admin.courses.view')->with('success', 'Curso actualizado exitosamente.');
    }



    public function destroy($id)
    {

        $course = Course::findOrFail($id);


        $course->users()->detach();

        $course->delete();

        return redirect()->route('admin.courses.view')->with('success', 'Curso eliminado con éxito.');
    }


    public function viewStudents(Request $request)
    {

        $courseName = $request->input('course_name');
        $period = $request->input('period');


        $periods = Course::distinct()->pluck('period');


        $students = User::with(['courses' => function ($query) use ($courseName, $period) {

            if ($courseName) {
                $query->where('name', 'like', '%' . $courseName . '%');
            }
            if ($period) {
                $query->where('period', $period);
            }
        }])
            ->where('role', 'student')
            ->has('courses')
            ->paginate(10);

        return view('admin.courses.matriculados', compact('students', 'periods'));
    }
}
