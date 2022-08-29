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

    public function __construct($file, $curriculumId, $content_order = 1){
        $this->file = $file;
        $this->curriculumId = $curriculumId;
        $this->content_order = $content_order;
    }


    public function createContent(){
        $uploadService = new UploadService($this->file);
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
        
        $courseContent = CourseContent::create([
            'curriculum_id'    => $this->curriculumId,
            'contentable_id'   => $newContent->id,
            'contentable_type' => $contentable_type,
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

        //compare old and new file types 
        
        $uploadService = new UploadService($this->file);
        $fileType = $uploadService->checkFileType();
        $fileExtension = $uploadService->getExtension();

        $oldFileType = Self::checkContentableType($courseContent);
        $content_order = $this->content_order = '' ? $this->content_order = 1 : $this->content_order; 

        //if new filetype is video
        if($fileType == 'video'){
            //if the new file type is video and the old file type is also video
            if($fileType == $oldFileType){
                $contentable_type = 'App\Models\Video';

                //delete old video and upload new one
                $uploadService = new UploadService($this->fileName);
                $videoDetails = $uploadService->updateVideo($courseContent, $this->file);

                //update video record
                $courseContent->contentable->update([
                    'video_name' => $videoDetails['videoHashName'],
                    'video_type' => $videoDetails['extension']
                ]);

            }else{
                //if the new file type is video and old file is document
                $contentable_type = 'App\Models\Video';
                
                //delete the old contentable record
                $courseContent->contentable->delete();

                //delete the old document
                $uploadService = new UploadService($this->fileName);
                $uploadService->deleteFile('documents/');

                //upload new video
                $uploadService = new UploadService($this->file);
                $fileNameToStore = $uploadService->uploadFile('/videos');

                //create new video record
                $newVideoContent = Self::createVideoContent($fileNameToStore, $fileExtension); 

                //update the content record
                $courseContent->update([
                    'contentable_id'   => $newVideoContent->id,
                    'contentable_type' => $contentable_type,
                    'content_order'    => $content_order

                ]);
            }

            
        }


        //if new filetype is document
        if($fileType == 'document'){
            //if the new file is a document and the old file is a document also
            if($fileType == $oldFileType){
                 $contentable_type = 'App\Models\CourseDoc';

                //delete old file and upload new one
                $uploadService = new UploadService($this->fileName);
                $docDetails = $uploadService->updateDoc($courseContent, $this->file);

                //update file record
                $courseContent->contentable->update([
                    'filename' => $docDetails['docHashName'],
                    'filetype' => $docDetails['extension']
                ]);
            }else{
                //if the new file type is document and old file is video
                $contentable_type = 'App\Models\CourseDoc';
                
                //delete the old contentable record
                $courseContent->contentable->delete();

                //delete the old video
                $uploadService = new UploadService($this->fileName);
                $uploadService->deleteFile('videos/');

                //upload new document
                $uploadService = new UploadService($this->file);
                $fileNameToStore = $uploadService->uploadFile('/documents');

                //create new document record
                $newDocContent = Self::createDocContent($fileNameToStore, $fileExtension); 

                //update the content record
                $courseContent->update([
                    'contentable_id'   => $newDocContent->id,
                    'contentable_type' => $contentable_type,
                    'content_order'    => $content_order
                ]);
            }
        }


        return 'Content Updated Successfully';
    }


}