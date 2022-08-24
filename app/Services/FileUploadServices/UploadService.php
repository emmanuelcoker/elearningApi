<?php

namespace App\Services\FileUploadServices;
use File;

class UploadService
{
    public $file;
    
    public function __construct($file){
        $this->file = $file;
    }

    //upload 
    public function uploadFile($path = '/img')
    {

        try{
            //get filename with the extension
           $filenameWithExt = $this->file->hashName();
          
           //get just filename
             $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           
           //get just extension
           $extension = $this->file->extension();
           // file name to store
           $filenameToStore = $filename.'.'.$extension;
           
           //upload image
           $path = $this->file->move(public_path($path),$filenameToStore);;

           return $filenameToStore;

       }catch(\Throwable $th){
           throw $th;
       }

    }


    //updating an existing image
       //update category image
    public function updateImg($model, $newImage){

            //delete old image
            $imageHashName = Self::deleteFile();

            //upload new file image
            $imageFile     = new UploadService($newImage);
            $imageHashName = $imageFile->uploadFile();
            $model->update(['banner_img' => $imageHashName]);

    }


    public function deleteFile($path = 'img/'){

        try {
            $imagePath = public_path($path.$this->file);
            if(File::exists($imagePath)){
                unlink($imagePath);
            } 
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
