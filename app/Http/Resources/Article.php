<?php

namespace Blog_Website_Laravel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //this will return all
        // return parent::toArray($request);
        
        //Customized json return
        return [
            'title' => $this->title,
        ];
    }
    public function with($request)
    {
        return[
            'author' => "moonlight"
        ];
    }
}
