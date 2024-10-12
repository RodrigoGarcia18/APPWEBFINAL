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
        // Obtén el usuario por su ID
        $user = User::with(['teacher', 'student'])->findOrFail($id);

        // Retorna la vista de edición con el usuario
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Encuentra el usuario por ID
        $user = User::findOrFail($id);
    
        // Actualiza los campos necesarios
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
        // Solo actualiza la contraseña si se proporciona
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        // Dependiendo del rol, actualiza la información correspondiente
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
    
        // Guarda el usuario
        $user->save();
    
        return redirect()->route('admin.users.view')->with('success', 'Usuario actualizado correctamente.');
    }
    
}
