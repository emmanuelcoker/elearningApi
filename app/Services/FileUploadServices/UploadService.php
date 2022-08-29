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



    //update video 
    public function updateVideo($model, $newVideo){

        //delete old image
        $videoHashName = Self::deleteFile('videos/');

        //upload new file image
        $videoFile     = new UploadService($newVideo);
        $extension = $videoFile->getExtension();
        $videoHashName = $videoFile->uploadFile('/videos');
        $model->update(['video_name' => $videoHashName, 'video_type' => $extension]);
        return ['videoHashName' => $videoHashName, 'extension' => $extension];
    }


    //update video 
    public function updateDoc($model, $newdoc){

        //delete old image
        $docHashName = Self::deleteFile('documents/');

        //upload new file image
        $docFile     = new UploadService($newdoc);
        $extension = $docFile->getExtension();
        $docHashName = $docFile->uploadFile('/documents');
        $model->update(['filename' => $docHashName, 'filetype' => $extension]);
        return ['docHashName' => $docHashName, 'extension' => $extension];

    }


    public function deleteFile($path = 'img/'){

        try {
            $filePath = public_path($path.$this->file);
            if(File::exists($filePath)){
                unlink($filePath);
            } 
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //check file extension 
    public function getExtension(){
        $extension = $this->file->extension();
        return $extension;
    }

    public function checkFileType(){
        $extension = $this->file->extension();

        $videoTypes     = ['flv','mp4','mkv','m3u8','avi','mov','ts','wmv'];
        $documentTypes  = ['csv','txt','xlx','xls','pdf','doc','docx','ppt','flv'];
        $imageTypes     = ['png','jpg', 'jpeg', 'tiff'];


        //check for video
        if(in_array($extension, $videoTypes)){
            return 'video';
        }

        if(in_array($extension, $documentTypes)){
            return 'document';
        }

        if(in_array($extension, $imageTypes)){
            return 'image';
        }
    }
}
