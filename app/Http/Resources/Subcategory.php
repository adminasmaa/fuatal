<?php
  
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class Subcategory extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' =>$this->title,
            'category_id'=>$this->category_id,
            'parent_id'=>$this->parent_id,
            'subcat_image'=>asset('uploads/categories/'. $this->subcat_image),
            'description' => $this->description,
            'created_at' => date('Y:m:d H:i:s'),
            'updated_at' => date('Y:m:d H:i:s'),
        ];
    }
    
}