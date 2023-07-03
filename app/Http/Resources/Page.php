<?php
  
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class Page extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content'=>$this->content,
            'parent_id'=>$this->parent_id,
            'slug'=>$this->slug,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y:m:d H:i:s'),
            'updated_at' => $this->updated_at->format('Y:m:d H:i:s'),
        ];
    }
    
}