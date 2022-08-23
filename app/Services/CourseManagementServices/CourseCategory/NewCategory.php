<?php

namespace App\Services\CourseManagementServices\CourseCategory;
use File;


abstract class NewCategory
{
    abstract public function createCategory();
    abstract public function allCategories();
    abstract public function updateCategory($categoryId, $data);
    abstract public function deleteCategory($categoryId);

    public function uploadImage($image, $path = '/img')
    {

        try{
            //get filename with the extension
           $filenameWithExt = $image->hashName();
          
           //get just filename
             $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           
           //get just extension
           $extension = $image->extension();
           // file name to store
           $filenameToStore = $filename.'.'.$extension;
           
           //upload image
           $path = $image->move(public_path($path),$filenameToStore);;

           return $filenameToStore;

       }catch(\Throwable $th){
           throw $th;
       }

    }

    public function deleteImage($image, $path = 'img/'){

        try {
            $imagePath = public_path($path.$image);
            if(File::exists($imagePath)){
                unlink($imagePath);
            } 
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}