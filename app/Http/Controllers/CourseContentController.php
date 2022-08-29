<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseContent;
use App\Models\Video;
use App\Models\CourseDoc;
use App\Http\Requests\NewCourseContentRequest;
use App\Http\Requests\UpdateCourseContentRequest;
use App\Services\CourseManagementServices\CourseContent\NewCourseContent;
use App\Services\FileUploadServices\UploadService;
use App\Services\MyResponseFormatter;

class CourseContentController extends Controller
{
    
    //get all course contents
    public function index(){

    }

    //create new content
    public function store(NewCourseContentRequest $request){
        $request->validated();
        
        $newCourseContent = new NewCourseContent($request->filename, $request->curriculum_id);
        $newContent = $newCourseContent->createContent();        
        return MyResponseFormatter::dataResponse($newContent, 'Content Uploaded Successfully!',201);
    }

    //show specific content with the uploaded video or document
    public function show($id){
        $content = CourseContent::with('contentable')->where('id', $id)->first();
        return MyResponseFormatter::dataResponse($content);
    }


    //update uploaded content
    public function update(UpdateCourseContentRequest $request, $id){
        $request->validated();
        $courseContent = CourseContent::find($id);

        $newCourseContent = new NewCourseContent($request->filename, $id, $request->content_order);
        $newContent = $newCourseContent->updateContent($id); 

        return MyResponseFormatter::messageResponse($newContent);
    }


}
