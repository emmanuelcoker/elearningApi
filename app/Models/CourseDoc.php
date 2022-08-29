<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDoc extends Model
{
    use HasFactory;

    protected $table = 'course_docs';

    protected $fillable = [
        'filename',
        'filetype'
    ];

    public function contents()
    {
        return $this->morphMany(CourseContent::class, 'contentable');
    }
}
