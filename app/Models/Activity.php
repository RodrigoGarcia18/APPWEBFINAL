<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

   
    protected $table = 'activities';

   
    protected $fillable = [
        'activity_code',
        'name',
        'description',
        'course_id',
        'start_date',
        'end_date',
    ];

    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    
    public function users()
    {
        return $this->belongsToMany(User::class, 'activity_user')
                    ->withTimestamps();
    }

   // Generar un código de actividad único sino gg al sistema
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            
            $activity->activity_code = 'ACT-' . strtoupper(uniqid());
        });
    }

    public function submissions()
    {
        return $this->hasMany(ActivitySubmission::class);
    }
}
