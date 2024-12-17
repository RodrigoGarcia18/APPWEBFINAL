<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    // Campos asignables
    protected $table = 'courses';
    protected $fillable = [
        'course_id',  // Código del curso
        'name',       // Nombre del curso
        'period',     // Período o semestre
        'description', // Descripción del curso (opcional)
        'session_link', //link(opcional)
        'precio'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user')->where('role', 'student');
    }
    public function teacher()
    {
        return $this->belongsToMany(User::class, 'course_user')
                    ->where('role', 'teacher');   
    }
    
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }


}


