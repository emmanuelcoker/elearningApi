<?php

namespace App\Services\CourseManagementServices\Courses;

use App\Services\FileUploadServices\UploadService;
use App\Models\Course;

class NewCourse
{

    public string $description;
    public string $title;
    public string $audience;
    public $start_day;
    public $end_day;
    public $requirements;
    public $prerequisites;
    public $pricing;
    public $banner_img;
    public $course_category_id;

    public function __construct($data){
        $this->description        = $data['description'];
        $this->title              = $data['title'];
        $this->audience           = $data['audience'];
        $this->start_day          = $data['start_day'];
        $this->end_day            = $data['end_day'];
        $this->prerequisites      = $data['prerequisites'];
        $this->requirements       = $data['requirements'];
        $this->pricing            = $data['pricing'];
        $this->banner_img         = $data['banner_img'];
        $this->course_category_id = $data['course_category_id'];

    }


    public function createCourse(){
        try {
           //upload file image
           $imageFile = new UploadService($this->banner_img);
           $imageHashName = $imageFile->uploadFile();
               
            $newCourse = Course::create([
                'description'               =>    $this->description,
                'title'                     =>    $this->title,
                'audience'                  =>    $this->audience,
                'starting_day'              =>    $this->start_day,
                'end_day'                   =>    $this->end_day,
                'requirements'              =>    $this->prerequisites,
                'prerequisites'             =>    $this->requirements,
                'pricing'                   =>    $this->pricing,
                'banner_img'                =>    $imageHashName,
                'course_category_id'        =>    $this->course_category_id
            ]);

            return $newCourse;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }


    //update course
    public function updateCourse($courseId, $data)
    {
        $course = Course::findOrFail($courseId);
        $course->update($data);
        return 'Course Updated Successfully';
    }

    //delete category
    public function deleteCourse($courseId)
    {
        try {
            $course  = Course::findOrFail($courseId);
            $imageFile = new UploadService($course->banner_img);
            $imageFile->deleteFile();
            $course->delete();
            return 'Course Deleted Successfully';
        } catch (\Throwable $th) {
            throw $th;
        }
       
    }

}