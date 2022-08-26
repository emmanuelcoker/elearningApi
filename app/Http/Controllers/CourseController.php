<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\NewCourseRequest;
use App\Services\CourseManagementServices\Courses\NewCourse;
use App\Services\FileUploadServices\UploadService;
use App\Services\MyResponseFormatter;

class CourseController extends Controller
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
    public function store(NewCourseRequest $request)
    {
        //validate request
        $request->validated();
        try {
           
            $data = $request->only('description', 'title', 'audience', 'start_day',
                                'end_day', 'requirements','prerequisites', 'pricing', 
                                'banner_img', 'course_category_id');
            
            $newCourse = new NewCourse($data);
            $course = $newCourse->createCourse();
            return MyResponseFormatter::dataResponse($course, 'Course Created Successfully', 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return MyResponseFormatter::dataResponse($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(NewCourseRequest $request, Course $course)
    {
        $request->validated();
        $uploadService = new UploadService($course->banner_img);

        //update image banner
        if($request->hasFile('banner_img')){
            //parameters of the method: model, old image , new image
            $uploadService->updateImg($course, $request->banner_img);
        }
    
        $course->update($request->only(
            'description', 'title', 'audience', 'start_day', 'end_day', 'requirements', 
            'prerequisites','pricing', 'banner_img', 'course_category_id'
        ));

        return MyResponseFormatter::messageResponse('Course Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {   
        $uploadService = new UploadService($course->banner_img);
        $uploadService->deleteFile();
        $course->delete();
        return MyResponseFormatter::messageResponse('Course Deleted Successfully!');
    }
}
