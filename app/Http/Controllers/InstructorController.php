<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Requests\NewInstructorRequest;
use App\Services\UserManagementServices\InstructorUser;
use App\Services\MyResponseFormatter;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instructor $instructor)
    {
        //
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
