<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue la convención de nombres
    protected $table = 'activities';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'activity_code',
        'name',
        'description',
        'course_id',
        'start_date',
        'end_date',
    ];

    // Relación con el modelo Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relación con el modelo User a través de la tabla pivote
    public function users()
    {
        return $this->belongsToMany(User::class, 'activity_user')
                    ->withTimestamps();
    }

    // Generar activity_code automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            // Generar un código de actividad único
            $activity->activity_code = 'ACT-' . strtoupper(uniqid());
        });
    }

    public function submissions()
    {
        return $this->hasMany(ActivitySubmission::class);
    }
}
