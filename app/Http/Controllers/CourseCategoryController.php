<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseManagementServices\CourseCategory\NewCourseCategory;
use App\Http\Requests\NewCourseCategoryRequest;
use App\Http\Requests\UpdateCourseCategoryRequest;
use App\Http\Resources\CourseCategoryResource;
use App\Services\MyResponseFormatter;
use App\Models\CourseCategory;

class CourseCategoryController extends Controller
{
    //get all course categories
    public function index(){
        $courseCategories = CourseCategory::latest()->paginate(40);
        return MyResponseFormatter::dataResponse(CourseCategoryResource::collection($courseCategories));
    }

    //create new course category
    public function store(NewCourseCategoryRequest $request){
        $request->validated();
        try{
            $newCategory = new NewCourseCategory($request->category_name, $request->info, $request->file('banner_img'));
            $newCategory->createCategory();
        }catch(\Throwable $th){
            throw $th;
        }
        return MyResponseFormatter::dataResponse($newCategory, 'Category Created Successfully', 201);
    }


    public function show(CourseCategory $category){
        return MyResponseFormatter::dataResponse(new CourseCategoryResource($category));
    }

    public function update(UpdateCourseCategoryRequest $request, $id){
        $request->validated();
        if(count($request->all()) >= 1){
            $data = $request->only('category_name', 'banner_img', 'info');
            $category = new NewCourseCategory();
            $resp = $category->updateCategory($id, $data);
            return MyResponseFormatter::messageResponse($resp);
        }
        return MyResponseFormatter::messageResponse('Empty Request Sent', 204);
       
    }

    public function delete($id){
        try {
            $category = new NewCourseCategory();
            $resp = $category->deleteCategory($id);
            return MyResponseFormatter::messageResponse($resp);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
