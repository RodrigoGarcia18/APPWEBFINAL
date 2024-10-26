<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateUserController extends Controller
{
    public function edit($id)
    {
        
        $user = User::with(['teacher', 'student'])->findOrFail($id);

       
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        
        $user = User::findOrFail($id);
    
        
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        
        if ($user->role === 'teacher') {
            $teacher = Teacher::where('user_id', $user->id)->first();
            $teacher->dni = $request->input('dni');
            $teacher->birth_date = $request->input('birth_date');
            $teacher->subject = $request->input('subject');
            $teacher->address = $request->input('address');
            $teacher->phone = $request->input('phone');
            $teacher->save();
        } elseif ($user->role === 'student') {
            $student = Student::where('user_id', $user->id)->first();
            $student->dni = $request->input('dni');
            $student->birth_date = $request->input('birth_date');
            $student->enrollment_number = $request->input('enrollment_number');
            $student->address = $request->input('address');
            $student->phone = $request->input('phone');
            $student->save();
        }
    
       
        $user->save();
    
        return redirect()->route('admin.users.view')->with('success', 'Usuario actualizado correctamente.');
    }
    
}
