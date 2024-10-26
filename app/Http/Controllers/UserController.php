<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        
        if ($request->filled('role') && $request->role != 'all') {
            $query->where('role', $request->role);
        }

        
        if ($request->filled('codigo')) {
            $query->where('codigo', 'like', '%' . $request->codigo . '%');
        }

        $users = $query->get();

        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        
        $user = User::with(['teacher', 'student'])->findOrFail($id);

        
        $teacher = $user->teacher ?? null;
        $student = $user->student ?? null;

        
        return view('admin.users.edit', compact('user', 'teacher', 'student'));
    }

    public function update(Request $request, $id)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'codigo' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed', 
            'role' => 'required|in:admin,teacher,student',
            'dni' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'subject' => 'nullable|string|max:255',
            'enrollment_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|string|max:255',
        ]);

        
        $user = User::findOrFail($id);

        
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->codigo = $validatedData['codigo'];

        
        if ($request->filled('password')) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->role = $validatedData['role'];
        $user->save(); 

        //ERROR: NO ACTUALIZA,
        //UPDATE: YA LO HACE XD
        Log::info("Usuario actualizado: " . $user->id . ", Rol: " . $user->role);

        
        if ($user->role === 'teacher') {
            
            $teacher = Teacher::where('user_id', $user->id)->first();
            Log::info("Registro Teacher encontrado: " . ($teacher ? $teacher->id : "Ninguno"));

            
            if ($teacher) {
                $teacher->dni = $validatedData['dni'];
                $teacher->birth_date = $validatedData['birth_date'];
                $teacher->subject = $validatedData['subject'];
                $teacher->address = $validatedData['address'];
                $teacher->phone = $validatedData['phone'];
                $teacher->profile_image = $validatedData['profile_image'];
                $teacher->save();
                Log::info("Datos Teacher actualizados: " . $teacher->id);
            }
        } elseif ($user->role === 'student') {
            
            $student = Student::where('user_id', $user->id)->first();
            Log::info("Registro Student encontrado: " . ($student ? $student->id : "Ninguno"));

            
            if ($student) {
                $student->dni = $validatedData['dni'];
                $student->birth_date = $validatedData['birth_date'];
                $student->enrollment_number = $validatedData['enrollment_number'];
                $student->address = $validatedData['address'];
                $student->phone = $validatedData['phone'];
                $student->profile_image = $validatedData['profile_image'];
                $student->save();
                Log::info("Datos Student actualizados: " . $student->id);
            }
        }

        
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente');
    }


    
    public function store(Request $request)
    {
        
        $validatedUserData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:student,teacher,admin', 
        ]);

        
        $user = User::create([
            'name' => $validatedUserData['name'],
            'email' => $validatedUserData['email'],
            'password' => Hash::make($validatedUserData['password']),
            'role' => $validatedUserData['role'], 
        ]);

        
        if ($validatedUserData['role'] === 'student') {
            
            $validatedStudentData = $request->validate([
                'dni' => 'required|string|max:20',
                'birth_date' => 'required|date',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'enrollment_number' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'grade' => 'nullable|string|max:50', 
            ]);

            
            Student::create([
                'user_id' => $user->id,
                'dni' => $validatedStudentData['dni'],
                'birth_date' => $validatedStudentData['birth_date'],
                'first_name' => $validatedStudentData['first_name'],
                'last_name' => $validatedStudentData['last_name'],
                'enrollment_number' => $validatedStudentData['enrollment_number'], 
                'address' => $validatedStudentData['address'],
                'phone' => $validatedStudentData['phone'],
                'grade' => $validatedStudentData['grade'], 
            ]);
        } elseif ($validatedUserData['role'] === 'teacher') {
            
            $validatedTeacherData = $request->validate([
                'dni' => 'required|string|max:20',
                'birth_date' => 'required|date',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'subject' => 'nullable|string|max:255', 
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
            ]);

            
            Teacher::create([
                'user_id' => $user->id,
                'dni' => $validatedTeacherData['dni'],
                'birth_date' => $validatedTeacherData['birth_date'],
                'first_name' => $validatedTeacherData['first_name'],
                'last_name' => $validatedTeacherData['last_name'],
                'subject' => $validatedTeacherData['subject'], 
                'address' => $validatedTeacherData['address'],
                'phone' => $validatedTeacherData['phone'],
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }
}
