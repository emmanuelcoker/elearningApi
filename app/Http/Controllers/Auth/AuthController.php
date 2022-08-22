<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NewUserRequest;
use App\Services\UserManagementServices\StudentUser;
use App\Services\UserManagementServices\InstructorUser;
use App\Services\MyResponseFormatter;


class AuthController extends Controller
{
    //register new User, Instuctor or Admin
    public function register(NewUserRequest $request){
        $request->validated();
        //normal user register
        $newStudent = new StudentUser($request->name, $request->email, $request->password);
        $token = $newStudent->createUser();
        return MyResponseFormatter::dataResponse($token, 'Registration Successful', 201);       
    }

    public function login(LoginRequest $request){
        $request->validated();
        $userService = new UserServices();
            $user =  $userService->getUserWithEmail($request->email);

            //check if user account exists
            if(is_null($user)) {  
                return MyJsonResponseFormatter::messageResponse('Your Account does not exist! Please Sign Up', 401);
            }

            //check if the passpword is correct
            if( Hash::check($request->password, $user->password) ){
                //create user login token
                $accessToken = $userService->generateAccessToken($user);
                return MyJsonResponseFormatter::dataResponse($accessToken, 'Login successful!');
            }
            
            return MyJsonResponseFormatter::messageResponse('Invalid Credientials', 400);
    }
}
