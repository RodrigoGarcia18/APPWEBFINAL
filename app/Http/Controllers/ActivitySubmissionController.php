<?php

namespace App\Http\Controllers;

use App\Models\ActivitySubmission;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

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
         $request->validate([
             'text_content' => 'nullable|string',
             'filepath' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048', 
         ]);

         $user = Auth::user(); 

         $submission = new ActivitySubmission(); 
         $submission->activity_id = $activityId; 
         $submission->user_id = $user->id; 
         $submission->text_content = $request->text_content; 
         
         if ($request->hasFile('filepath')) {
             $submission->filepath = $request->file('filepath')->store('uploads', 'public'); 
         }
         
         $submission->save(); 
 
         return redirect()->route('student.courses.view')->with('success', 'Actividad enviada correctamente.');
     }
}   
    