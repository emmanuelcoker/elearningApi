<?php

namespace App\Services\UserManagementServices;
use App\Services\UserManagementServices\NewUser;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;

class StudentUser extends NewUser{

    public $name;
    protected $email;
    private $password;
    private $provider_id;
    private $provider_name;

    public function __construct($name, $email, $password, $provider_id = null, $provider_name = null){
        $this->name =  $name;
        $this->email = $email;
        $this->password = Hash::make($password);
        $this->provider_id = $provider_id;
        $this->provider_name = $provider_name;
    }

     //create new user
     public function createUser(){
            $newUser = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' =>$this->password,
                'provider_id' => $this->provider_id,
                'provider_name' => $this->provider_name,
            ]);

            $token = Self::generateAccessToken($newUser);

            return $token;
     }


     //update user
     public function updateUser(){

     }
 
     //delete
     public function deleteUser(){

     }
}