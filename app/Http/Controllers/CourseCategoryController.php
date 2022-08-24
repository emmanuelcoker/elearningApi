<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseManagementServices\CourseCategory\NewCourseCategory;
use App\Services\FileUploadServices\UploadService;
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
    
        try {
            $request->validated();

            if(count($request->all()) >= 1){        
                $category = new NewCourseCategory();
                $findCategory = CourseCategory::find($id);
                $uploadService = new UploadService($findCategory->banner_img);

                //update image banner
                if($request->hasFile('banner_img')){
                    //parameters of the method: model, old image , new image
                    $uploadService->updateImg($findCategory, $request->banner_img);
                }
    
                $resp = $category->updateCategory($id, $request->only('category_name', 'info'));
                return MyResponseFormatter::messageResponse($resp);
            }

            return MyResponseFormatter::messageResponse('Empty Request Sent', 204);

        } catch (\Throwable $th) {
            throw $th;
        }
       
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
