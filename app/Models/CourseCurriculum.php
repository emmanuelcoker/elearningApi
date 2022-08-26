<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCurriculum extends Model
{
    use HasFactory;

    protected $table = 'course_curricula';

    protected $fillable = [
        'curriculum_title',
        'curriculum_number',
        'course_id',
        'objectives'
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    
}
