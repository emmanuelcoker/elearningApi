<?php

namespace App\Services\CourseManagementServices\CourseCategory;

use App\Services\CourseManagementServices\CourseCategory\NewCategory;
use App\Models\CourseCategory;


class NewCourseCategory extends NewCategory
{

    public $category_name;
    public $banner_img;
    public $info;

    public function __construct($category_name = null, $info = null, $banner_img = null){
        $this->category_name = $category_name;
        $this->info = $info;
        $this->banner_img = $banner_img;
    }

    public function allCategories()
    {
        $categories = CourseCategory::latest()->paginate(20);
        return $categories;
    }

    public function createCategory()
    {
        
        //upload file image
        $imageFile = parent::uploadImage($this->banner_img);

        $newcategory = CourseCategory::firstOrCreate([
            'category_name' => $this->category_name,
            'banner_img' => $imageFile,
            'info' => $this->info,
        ]);

        return $newcategory;
    }

    public function updateCategory($categoryId, $data)
    {
        $category = CourseCategory::findOrFail($categoryId);
        $category->update($data);
        return 'Category Updated Successfully';
    }


    public function deleteCategory($categoryId)
    {
        try {
            $category = CourseCategory::findOrFail($categoryId);
            $imageFile = parent::deleteImage($category->banner_img);
            $category->delete();
            return 'Category Deleted Successfully';
        } catch (\Throwable $th) {
            throw $th;
        }
       
       
    }

}