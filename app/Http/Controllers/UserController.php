<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filtrado por rol
        if ($request->filled('role') && $request->role != 'all') {
            $query->where('role', $request->role);
        }

        // Filtrado por código
        if ($request->filled('codigo')) {
            $query->where('codigo', 'like', '%' . $request->codigo . '%');
        }

        $users = $query->get();

        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        // Buscar el usuario por ID y cargar las relaciones de teacher o student si existen
        $user = User::with(['teacher', 'student'])->findOrFail($id);

        // Inicializar las variables para teacher y student
        $teacher = $user->teacher ?? null;
        $student = $user->student ?? null;

        // Pasar las variables a la vista
        return view('admin.users.edit', compact('user', 'teacher', 'student'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'codigo' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed', // Contraseña opcional
            'role' => 'required|in:admin,teacher,student',
            // Campos adicionales para teacher o student
            'dni' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'subject' => 'nullable|string|max:255',
            'enrollment_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|string|max:255',
        ]);

        // Encontrar el usuario
        $user = User::findOrFail($id);

        // Actualizar datos generales del usuario
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->codigo = $validatedData['codigo'];

        // Solo actualizar contraseña si se ha ingresado
        if ($request->filled('password')) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->role = $validatedData['role'];
        $user->save(); // Guardar cambios del usuario

        // Log para verificar el rol del usuario
        Log::info("Usuario actualizado: " . $user->id . ", Rol: " . $user->role);

        // Actualizar información específica según el rol
        if ($user->role === 'teacher') {
            // Buscar el registro de Teacher
            $teacher = Teacher::where('user_id', $user->id)->first();
            Log::info("Registro Teacher encontrado: " . ($teacher ? $teacher->id : "Ninguno"));

            // Si existe, actualiza
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
            // Buscar el registro de Student
            $student = Student::where('user_id', $user->id)->first();
            Log::info("Registro Student encontrado: " . ($student ? $student->id : "Ninguno"));

            // Si existe, actualiza
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

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente');
    }


    
    public function store(Request $request)
    {
        // Validar los datos básicos del usuario
        $validatedUserData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:student,teacher,admin', // Aseguramos que el rol sea válido
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $validatedUserData['name'],
            'email' => $validatedUserData['email'],
            'password' => Hash::make($validatedUserData['password']),
            'role' => $validatedUserData['role'], // Agregar el campo 'role' aquí
        ]);

        // Validar y crear perfil según el rol
        if ($validatedUserData['role'] === 'student') {
            // Validar datos específicos del estudiante
            $validatedStudentData = $request->validate([
                'dni' => 'required|string|max:20',
                'birth_date' => 'required|date',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'enrollment_number' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'grade' => 'nullable|string|max:50', // Campo grado opcional
            ]);

            // Crear el perfil de estudiante
            Student::create([
                'user_id' => $user->id,
                'dni' => $validatedStudentData['dni'],
                'birth_date' => $validatedStudentData['birth_date'],
                'first_name' => $validatedStudentData['first_name'],
                'last_name' => $validatedStudentData['last_name'],
                'enrollment_number' => $validatedStudentData['enrollment_number'], // Permitir nulo
                'address' => $validatedStudentData['address'],
                'phone' => $validatedStudentData['phone'],
                'grade' => $validatedStudentData['grade'], // Permitir nulo
            ]);
        } elseif ($validatedUserData['role'] === 'teacher') {
            // Validar datos específicos del docente
            $validatedTeacherData = $request->validate([
                'dni' => 'required|string|max:20',
                'birth_date' => 'required|date',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'subject' => 'nullable|string|max:255', // Campo opcional
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
            ]);

            // Crear el perfil de docente
            Teacher::create([
                'user_id' => $user->id,
                'dni' => $validatedTeacherData['dni'],
                'birth_date' => $validatedTeacherData['birth_date'],
                'first_name' => $validatedTeacherData['first_name'],
                'last_name' => $validatedTeacherData['last_name'],
                'subject' => $validatedTeacherData['subject'], // Permitir nulo
                'address' => $validatedTeacherData['address'],
                'phone' => $validatedTeacherData['phone'],
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }
}
