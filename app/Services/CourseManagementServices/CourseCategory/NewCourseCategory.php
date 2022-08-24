<?php

namespace App\Services\CourseManagementServices\CourseCategory;

use App\Services\CourseManagementServices\CourseCategory\NewCategory;
use App\Services\FileUploadServices\UploadService;
use App\Models\CourseCategory;


class NewCourseCategory extends NewCategory
{

    public $category_name;
    public $banner_img;
    public $info;

    public function __construct($category_name = null, $info = null, $banner_img = null){
        $this->category_name = $category_name;
        $this->info          = $info;
        $this->banner_img    = $banner_img;
    }

    //get all course categories with pagination
    public function allCategories()
    {
        $categories = CourseCategory::latest()->paginate(20);
        return $categories;
    }

    //create a new course category
    public function createCategory()
    {   
        //upload file image
        $imageFile     = new UploadService($this->banner_img);
        $imageHashName = $imageFile->uploadFile();

        $newcategory = CourseCategory::firstOrCreate([
            'category_name' => $this->category_name,
            'banner_img'    => $imageHashName,
            'info'          => $this->info,
        ]);

        return $newcategory;
    }

    //update category
    public function updateCategory($categoryId, $data)
    {
        $category = CourseCategory::findOrFail($categoryId);
        $category->update($data);
        return 'Category Updated Successfully';
    }


    //delete category
    public function deleteCategory($categoryId)
    {
        try {
            $category  = CourseCategory::findOrFail($categoryId);
            $imageFile = new UploadService($category->banner_img);
            $imageFile->deleteFile();
            $category->delete();
            return 'Category Deleted Successfully';
        } catch (\Throwable $th) {
            throw $th;
        }
       
    }

}