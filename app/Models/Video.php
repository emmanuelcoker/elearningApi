<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';

    protected $fillable = [
        'video_name',
        'video_type'
    ];


    public function contents()
    {
        return $this->morphMany(CourseContent::class, 'contentable');
    }

}
