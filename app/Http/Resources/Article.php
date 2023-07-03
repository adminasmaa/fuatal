<?php
  
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content'=>$this->content,
            'category_id'=>$this->category_id,
            'slug'=>$this->slug,
            'description' => $this->description,
            'published_at'=>$this->published_at,
            'created_at' => $this->created_at->format('Y:m:d H:i:s'),
            'updated_at' => $this->updated_at->format('Y:m:d H:i:s'),
        ];
    }
    
}