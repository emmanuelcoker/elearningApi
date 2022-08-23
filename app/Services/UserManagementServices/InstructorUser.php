<?php

namespace App\Services\UserManagementServices;
use App\Services\UserManagementServices\NewUser;
use App\Services\MyResponseFormatter;

use App\Models\Instructor;
use App\Models\User;
use App\Models\Role;

class InstructorUser extends NewUser{

    public $about;
    public $sub_title;
    public $youtube_link;
    public $website_link;
    public $twitter_link;
    public $linkedin_link;
    private $roleId = 2;

    public function __construct($sub_title = null, $about = null, $website_link = null, $twitter_link = null, $youtube_link = null, $linkedin_link = null){
        $this->sub_title = $sub_title;
        $this->about = $about;
        $this->website_link = $website_link;
        $this->twitter_link = $twitter_link;
        $this->youtube_link = $youtube_link;
        $this->linkedin_link = $linkedin_link;
    }

     //create new user
     public function createUser(){
            $newInstructor = Instructor::firstOrCreate([
                'user_id' => auth()->user()->id,
                'sub_title' =>$this->sub_title,
                'about' => $this->about,
                'website_link' => $this->website_link,
                'twitter_link' => $this->twitter_link,
                'youtube_link' => $this->youtube_link,
                'linkedin_link' => $this->linkedin_link,
            ]);

            auth()->user()->roles()->attach($this->roleId);
            return $newInstructor;
     }


     //update user instructor profile
     public function updateUser($data){
        //check if the user has the role
        auth()->user()->instructor_profile()->update($data);
        return 'Profile Updated Successfully';
     }
 
     //delete
     public function deleteUser(){

     }
}