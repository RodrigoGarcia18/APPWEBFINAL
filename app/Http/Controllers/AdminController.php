<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\Teacher;

class AdminController extends Controller
{

    public function viewUsers(Request $request)
    {
        
        $query = User::query();

        
        if ($request->filled('role') && $request->role != 'all') { 
            $query->where('role', $request->role);
        }

       
        if ($request->filled('codigo')) {
            $query->where('codigo', $request->codigo);
        }

        
        if ($request->filled('dni')) {
            $query->where('dni', $request->dni);
        }

        
        $users = $query->get();

        
        if ($request->ajax()) {
            return view('admin.users.partials.user_table', compact('users'));
        }

        return view('admin.users.index', compact('users')); 
    }

    
    public function createUser()
    {
        return view('admin.users.create'); 
    }

    public function edit($id)
    {

        $user = User::with(['teacher', 'student'])->findOrFail($id);


        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'codigo' => 'nullable|string',
            'password' => 'nullable|string|min:8',
            'dni' => 'required|string|max:20|unique:teachers,dni,' . $request->input('dni'),
            'birth_date' => 'nullable|date',
            'subject' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'enrollment_number' => 'required|string|max:20|unique:students,enrollment_number,' . $request->input('enrollment_number'),
        ]);


        $user = User::findOrFail($id);


        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->codigo = $request->input('codigo');
        $user->save();


        if ($user->role === 'teacher') {
            $user->teacher()->update([
                'dni' => $request->input('dni'),
                'birth_date' => $request->input('birth_date'),
                'subject' => $request->input('subject'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
            ]);
        } elseif ($user->role === 'student') {
            $user->student()->update([
                'dni' => $request->input('dni'),
                'birth_date' => $request->input('birth_date'),
                'enrollment_number' => $request->input('enrollment_number'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
            ]);
        }

 
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }
    
    
    

    
    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'codigo' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,teacher,student',
            'dni' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'enrollment_number' => 'nullable|string|max:255',
        ]);


        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'codigo' => $validatedData['codigo'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ]);


        if ($validatedData['role'] === 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'dni' => $validatedData['dni'],
                'birth_date' => $validatedData['birth_date'],
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'],
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'subject' => $validatedData['subject'],
            ]);
        } elseif ($validatedData['role'] === 'student') {
            Student::create([
                'user_id' => $user->id,
                'dni' => $validatedData['dni'],
                'birth_date' => $validatedData['birth_date'],
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'],
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'enrollment_number' => $validatedData['enrollment_number'],
            ]);
        }

        return redirect()->route('admin.users.view')->with('success', 'Usuario creado con éxito.');
    }


    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.view')->with('success', 'Usuario eliminado correctamente.');
    }
  



    public function viewCourses()
    {
        return view('admin.courses.index');
    }



    public function storeCourse(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'period' => 'required|string|max:100', 
            'user_ids' => 'required|array', 
            'user_ids.*' => 'exists:users,id',
        ]);
    
        $course = Course::create([
            'name' => $request->name,
            'course_id' => $request->course_id,
            'description' => $request->description,
            'period' => $request->period, 
            'session_link' => null, 
        ]);
    
        
        $course->users()->attach($request->user_ids);
    
        return redirect()->route('admin.courses.view')->with('success', 'Curso creado exitosamente.');
    }


    
    
    public function viewReports()
    {
        return view('admin.reports');
    }
    
}
