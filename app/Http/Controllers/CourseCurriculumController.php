<?php

namespace App\Http\Controllers;

use App\Models\CourseCurriculum;
use Illuminate\Http\Request;
use App\Http\Requests\NewCourseCurriculumRequest;
use App\Services\MyResponseFormatter;

class CourseCurriculumController extends Controller
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
    public function store(NewCourseCurriculumRequest $request)
    {
        $request->validated();

        $newCurriculum =  CourseCurriculum::create($request->only('curriculum_title',
                                'curriculum_number', 'course_id', 'objectives'));

        return MyResponseFormatter::dataResponse($newCurriculum, 'New Curriculum created Successfully', 201);
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseCurriculum  $courseCurriculum
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $courseCurriculum = CourseCurriculum::with([
            'content' => ['contentable']
        ])->where('id', $id)->first();
        return MyResponseFormatter::dataResponse($courseCurriculum);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseCurriculum  $courseCurriculum
     * @return \Illuminate\Http\Response
     */
    public function update(NewCourseCurriculumRequest $request, $id)
    {
        $request->validated();
        $courseCurriculum = CourseCurriculum::findOrFail($id);
        $courseCurriculum->update($request->validated());

        return MyResponseFormatter::messageResponse('Curriculum Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseCurriculum  $courseCurriculum
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseCurriculum $courseCurriculum)
    {
        //delete curriculum
        $courseCurriculum->delete();
        return MyResponseFormatter::messageResponse('Curriculum Deleted Successfully');
    }
}
