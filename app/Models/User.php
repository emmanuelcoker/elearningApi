<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_img'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //user role relationship
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_users')->as('roles')->using(RolesUser::class);
    }

    //relationship with instructor model
    public function instructor_profile(){
        return $this->hasOne(Instructor::class, 'user_id');
    }

    //many to many with courses
    public function courses()
    {
        return $this->belongsToMany(Course::class)->using(CourseUser::class)->as('courses');
    }
    
}
