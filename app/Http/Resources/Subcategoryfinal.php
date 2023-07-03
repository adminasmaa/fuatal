<?php
  
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class Subcategoryfinal extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' =>$this->title,
            'category_id'=>$this->category_id,
            'subcategory_id'=>$this->subcategory_id,
            'parent_id'=>$this->parent_id,
            'subcat_image_final'=>$this->subcat_image_final,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y:m:d H:i:s'),
            'updated_at' => $this->updated_at->format('Y:m:d H:i:s'),
        ];
    }
    
}