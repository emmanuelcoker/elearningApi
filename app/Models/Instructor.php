<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    protected $table = 'instructors';

    protected $fillable = [
        'user_id',
        'about',
        'sub_title',
        'youtube_link',
        'twitter_link',
        'website_link',
        'linkedin_link'
    ];
    

    //one to one relationship with user
    public function user(){
        return $this->belongsTo(User::class);
    }
}
