<?php
  
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'trans_id' => $this->trans_id,
            'title' => $this->title,
            'title_ar' => $this->title_ar,
            'cat_image'=>asset('uploads/categories/'. $this->cat_image),
            'description' => is_null($this->description) ? '' : $this->description,
            'color_code' => is_null($this->color_code) ? "" : $this->color_code,
            'created_at' => date('d-m-Y'),
            'updated_at' => date('d-m-Y'),
            

        ];
    }
    
}