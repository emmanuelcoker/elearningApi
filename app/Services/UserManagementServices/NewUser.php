<?php

namespace App\Services\UserManagementServices;

abstract class NewUser{
    //create new user
    abstract function createUser();

    //update user
    abstract function updateUser($data);

    //delete
    abstract function deleteUser();

    //generate user access token
    public function generateAccessToken($user, $token_name = 'user_token'){
        $accessToken = $user->createToken($token_name)->plainTextToken;
        return $accessToken;
    }
    

}