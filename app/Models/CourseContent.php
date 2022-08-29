<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseContent extends Model
{
    use HasFactory;

    protected $table = 'course_contents';

    protected $fillable = [
        'contentable_id',
        'contentable_type',
        'content_order',
        'curriculum_id'
    ];


    public function contentable()
    {
        return $this->morphTo();
    }

    public function curriculum(){
        return $this->belongsTo(CourseCurriculum::class);
    }

}
