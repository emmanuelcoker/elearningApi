<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Requests\NewInstructorRequest;
use App\Services\UserManagementServices\InstructorUser;
use App\Services\MyResponseFormatter;
use App\Http\Resources\InstructorUserResource;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all instructors and their profiles
        $instructors = Instructor::latest()->paginate(40);
        return MyResponseFormatter::dataResponse(InstructorUserResource::collection($instructors));       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewInstructorRequest $request)
    {   
        
        $request->validated();
        //Register As Instructor
        $newInstructor = new InstructorUser(
                $request->sub_title, $request->about, $request->website_link,
                $request->twitter_link, $request->youtube_link, $request->linkedin_link);

        $instructor = $newInstructor->createUser();
        return MyResponseFormatter::dataResponse($instructor, 'Registration Successful', 201);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function show(Instructor $instructor)
    {
        //show instructor profile
        return MyResponseFormatter::dataResponse( new InstructorUserResource($instructor));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function update(NewInstructorRequest $request)
    {
        //validate request
        $request->validated();
        $data = $request->only('about', 'sub_title', 'website_link', 'twitter_link', 'youtube_link', 'linkedin_link');
        $instructor = new InstructorUser();
        $resp = $instructor->updateUser($data);
        return MyResponseFormatter::messageResponse($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instructor $instructor)
    {
        //
    }
}
