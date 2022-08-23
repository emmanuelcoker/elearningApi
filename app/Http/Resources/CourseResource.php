<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'description'  => $this->description ,
            'title'  => $this->title,
            'audience'  => $this->audience ,
            'start_day'  => $this->start_day,
            'end_day'  => $this->end_day,
            'requirements'  => $this->requirements,
            'prerequisites'  => $this->prerequisites,
            'pricing'  => $this->pricing,
            'banner_img'  => $this->banner_img
        ];
    }
}
