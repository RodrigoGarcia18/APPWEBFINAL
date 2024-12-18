<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = 'notas'; 
    protected $fillable = [
        'activity_submission_id',
        'nota',
    ];

    public function activitySubmission()
    {
        return $this->belongsTo(ActivitySubmission::class);
    }
}
