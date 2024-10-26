<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Activity;


class StudentController extends Controller
{
    
    public function viewProfile()
    {
        return view('student.profile');
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
    
        
        if ($request->has('course_period') && $request->input('course_period') !== '') {
            $courses = $courses->filter(function ($course) use ($request) {
                return $course->period === $request->input('course_period'); 
            });
        }
    
     
        $periods = Course::distinct()->pluck('period')->sort();
    
        return view('student.courses', compact('courses', 'periods'));
    }
    
    
    
    

    public function showCourseDetails($id)
    {
        
        $course = Course::with(['users', 'activities'])->findOrFail($id); 
    
        
        $teachers = $course->users->filter(function($user) {
            return $user->role === 'teacher'; 
        });
    
        
        $activities = $course->activities;
    
        
        return view('student.details', compact('course', 'teachers', 'activities'));
    }
    
    
    
    
    public function viewActivities(Request $request)
    {
        $user = Auth::user();
        
        
        $courses = $user->courses; 
    
        
        $courses->load(['activities.submissions.nota']); 
    
        
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
        
        
        if ($request->has('course_period') && $request->input('course_period') !== '') {
            $courses = $courses->filter(function ($course) use ($request) {
                return $course->period === $request->input('course_period'); 
            });
        }
        
        
        $periods = Course::distinct()->pluck('period')->sort(); 
    
        return view('student.activities', compact('courses', 'periods'));
    }
    
    

    


}
