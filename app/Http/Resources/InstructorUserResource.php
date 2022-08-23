<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class InstructorUserResource extends JsonResource
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
            'sub_title' => $this->sub_title,
            'about' => $this->about,
            'website_link' => $this->website_link, 
            'twitter_link' => $this->twitter_link, 
            'youtube_link' => $this->youtube_link, 
            'linkedin_link' => $this->linkedin_link, 
            'user' =>  new UserResource($this->user), 
        ];
    }
}
