<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Método para mostrar la lista de usuarios
    public function viewUsers()
    {
        return view('admin.users');
    }

    // Método para almacenar un nuevo usuario
    public function storeUser(Request $request)
    {
        // Validación de datos (puedes agregar más reglas)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        // Aquí podrías agregar lógica para guardar el usuario en la base de datos
        // User::create([...]);

        return redirect()->route('admin.users.view')->with('success', 'Usuario creado correctamente.');
    }

    // Método para mostrar la lista de cursos
    public function viewCourses()
    {
        return view('admin.courses');
    }

    // Método para almacenar un nuevo curso
    public function storeCourse(Request $request)
    {
        // Validación de datos (puedes agregar más reglas)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Aquí podrías agregar lógica para guardar el curso en la base de datos
        // Course::create([...]);

        return redirect()->route('admin.courses.view')->with('success', 'Curso creado correctamente.');
    }

    // Método para mostrar reportes
    public function viewReports()
    {
        return view('admin.reports');
    }
}
