<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';

    protected $fillable = [
        'description',
        'title',
        'audience',
        'starting_day',
        'end_day',
        'requirements',
        'prerequisites',
        'pricing',
        'banner_img',
        'course_category_id'
    ];

    public function category(){
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function curricula(){
        return $this->hasMany(CourseCurriculum::class, 'course_id')->orderBy('curriculum_number')->withDefault();
    }
}
