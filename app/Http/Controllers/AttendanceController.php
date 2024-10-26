<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function create(Request $request, $courseId)
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes estar autenticado para acceder a esta página.');
        }
    
        $course = Course::findOrFail($courseId);
        
        $students = $course->students; 
    
        return view('attendance.create', compact('course', 'students'));
    }   
    
    
    public function view()
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes estar autenticado para acceder a esta página.');
        }
    
  
        $courses = $user->courses; 
    

        $attendances = [];
        foreach ($courses as $course) {

            $attendances[$course->id] = Attendance::where('course_id', $course->id)->get();
        }
    

        return view('attendance.view', compact('courses', 'attendances'));
    }
    
    

    public function mark(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'attendance_date' => 'required|date',
            'students' => 'required|array',
            'students.*.id' => 'required|exists:users,id', 
            'students.*.status' => 'required|in:present,absent,late',
        ]);
    
        foreach ($request->students as $student) {
            Attendance::updateOrCreate(
                [
                    'course_id' => $request->course_id,
                    'user_id' => $student['id'], 
                    'attendance_date' => $request->attendance_date,
                ],
                [
                    'status' => $student['status'],
                ]
            );
        }
    
        return redirect()->route('teacher.attendance.view')->with('success', 'Asistencia marcada con éxito.');
    }

    public function viewDetails(Request $request, $courseId)
    {

        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes estar autenticado para acceder a esta página.');
        }
    
 
        $course = Course::findOrFail($courseId);
        
  
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        
  
        $attendances = Attendance::where('course_id', $courseId)
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->with('user')
            ->get();
    
        return view('attendance.viewdetails', compact('course', 'attendances', 'startDate', 'endDate'));
    }
    
    
}
