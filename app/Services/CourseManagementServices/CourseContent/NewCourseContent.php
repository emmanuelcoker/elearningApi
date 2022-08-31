<?php

namespace App\Services\CourseManagementServices\CourseContent;

use App\Services\FileUploadServices\UploadService;

use App\Models\Video;
use App\Models\CourseContent;
use App\Models\CourseDoc;

class NewCourseContent
{

    public $file;
    public $curriculumId;
    public $content_order;
    public $fileName;
    private $pathToVideo = '/videos';
    private $pathToDelVideo = 'videos/';

    private $pathToDocs = '/documents';
    private $pathToDelDocs = 'documents/';

    private $contentable_type;

    public function __construct($file, $curriculumId, $content_order = 1){
        $this->file = $file;
        $this->curriculumId = $curriculumId;
        $this->content_order = $content_order;
    }

//creating and uploading content
    public function storeContentFile($file){
        $uploadService = new UploadService($file);
        $fileType = $uploadService->checkFileType();
        $fileExtension = $uploadService->getExtension();
        
        if($fileType == 'video'){
            $contentable_type = 'App\Models\Video';
            $fileNameToStore = $uploadService->uploadFile('/videos');
            $newContent = Self::createVideoContent($fileNameToStore, $fileExtension);
        }

        if($fileType == 'document'){
            $contentable_type = 'App\Models\CourseDoc';
            $fileNameToStore = $uploadService->uploadFile('/documents');
            $newContent = Self::createDocContent($fileNameToStore, $fileExtension);
        }

        return ['newContent' => $newContent, 'contentable_type' => $contentable_type];
    }

    public function createContent(){
        $newContent = Self::storeContentFile($this->file);

        $courseContent = CourseContent::create([
            'curriculum_id'    => $this->curriculumId,
            'contentable_id'   => $newContent['newContent']->id,
            'contentable_type' => $newContent['contentable_type'],
            'content_order'    => $this->content_order
        ]);

        return $courseContent;
    }


    //create video content
    public function createVideoContent($fileNameToStore, $fileExtension){
        $newVideo = Video::create([
            'video_name' => $fileNameToStore,
            'video_type' => $fileExtension
        ]);

        return $newVideo;
    }

    //create document content

    public function createDocContent($fileNameToStore, $fileExtension){
        $newDoc =  CourseDoc::create([
            'filename'  => $fileNameToStore,
            'filetype' => $fileExtension
        ]);

        return $newDoc;
    }

    public function checkContentableType($model){
        if($model->contentable_type == 'App\Models\Video'){
            $this->fileName = $model->contentable->video_name;
            $oldFileType =  'video';
        }

        if($model->contentable_type == 'App\Models\CourseDoc'){
            $this->fileName = $model->contentable->filename;
            $oldFileType =  'document';
        }

        return $oldFileType;
    }

    public function updateContent($id){
        $courseContent = CourseContent::findOrFail($id);
       
        $uploadService = new UploadService($this->file);
        $fileType = $uploadService->checkFileType();

        $oldFileType = Self::checkContentableType($courseContent);

        //if new filetype is video
        if($fileType == 'video'){
            //if the new file type is video and the old file type is also video
            if($fileType == $oldFileType){
                //update old video and content
                Self::updateOldVideo($this->fileName, $this->file, $courseContent);
            }else{
                //if the new file type is video and old file is document
                $newVideoContent = Self::updateDocToVideo($this->fileName, $this->file, $courseContent, 
                                                $this->pathToDelDocs, $this->pathToVideo);
            }
        }

        //if new filetype is document
        if($fileType == 'document'){
            //if the new file is a document and the old file is a document also
            if($fileType == $oldFileType){
                Self::updateOldDoc($this->fileName, $this->file, $courseContent);
            }else{
                //if the new file type is doc and the old is video
                $newDocContent = Self::updateVideoToDoc($this->fileName, $this->file, $courseContent, 
                                            $this->pathToDelVideo, $this->pathToDocs);
            }
        }
            
       

        return 'Content Updated Successfully';
    }


    //changing the old video to new one
    public function updateOldVideo($oldFile, $newFile, $model){
        $uploadService = new UploadService($oldFile);
        $videoDetails = $uploadService->updateVideo($model, $newFile);
         //update video record
         $model->contentable->update([
            'video_name' => $videoDetails['videoHashName'],
            'video_type' => $videoDetails['extension']
        ]);
    }

    //changing the old document to a new one
    public function updateOldDoc($oldFile, $newFile, $model){
        //delete old file and upload new one
        $uploadService = new UploadService($oldFile);
        $docDetails = $uploadService->updateDoc($model, $newFile);

        //update file record
        $model->contentable->update([
            'filename' => $docDetails['docHashName'],
            'filetype' => $docDetails['extension']
        ]);
    }


    public function updateDocToVideo($oldDocFile, $newVidFile, $model, $oldDocPath, $newVidPath){
        //if the new file type is video and old file is doc
        $contentable_type =  'App\Models\Video';
        //delete the old contentable record
        $model->contentable->delete();
        $content_order = $this->content_order = '' ? $this->content_order = 1 : $this->content_order; 
        Self::deleteFile($oldDocFile, $oldDocPath);

        //upload new video
        $uploadService = new UploadService($newVidFile);
        $fileExtension = $uploadService->getExtension();
        $fileNameToStore = $uploadService->uploadFile($newVidPath);

        //create new video record
        $newVidContent = Self::createVideoContent($fileNameToStore, $fileExtension); 
         //update the content record
         $model->update([
            'contentable_id'   => $newVidContent->id,
            'contentable_type' => $contentable_type,
            'content_order'    => $content_order
        ]);
    }

    public function updateVideoToDoc($oldVidFile, $newDocFile, $model, $oldVidPath, $newDocPath){
        //if the new file type is document and old file is video
        $contentable_type =  'App\Models\CourseDoc';
        //delete the old contentable record
        $model->contentable->delete();
        $content_order = $this->content_order = '' ? $this->content_order = 1 : $this->content_order; 

        Self::deleteFile($oldVidFile, $oldVidPath);

        //upload new document
        $uploadService = new UploadService($newDocFile);
        $fileExtension = $uploadService->getExtension();
        $fileNameToStore = $uploadService->uploadFile($newDocPath);

        //create new document record
        $newDocContent = Self::createDocContent($fileNameToStore, $fileExtension); 
        $model->update([
            'contentable_id'   => $newDocContent->id,
            'contentable_type' => $contentable_type,
            'content_order'    => $content_order
        ]);
    }

    //upload new file
    public function newFile($file, $path){
        $uploadService = new UploadService($file);
        $fileNameToStore = $uploadService->uploadFile($path);
        return $fileNameToStore;
    }

    //delete file
    public function deleteFile($file, $path){
        $uploadService = new UploadService($file);
        $uploadService->deleteFile($path);
    }

}