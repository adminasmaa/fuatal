<?php
  
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{

    public function toArray($request)
    {
        $images = explode(',',$this->image);
        return [
            'id' => $this->id,
            'title' =>$this->title,
            'title_ar' =>$this->title_ar,
            'category_id'=>$this->category_id,
            'parent_id'=>$this->parent_id,
            'trans_id'=>$this->trans_id,
            'image'=> count($images) ? asset('uploads/categories/'. $images[0]) : "",
            'price'=>$this->price,
            'product_size'=>$this->product_size,
            'sku'=>$this->sku,
            'nutritional_info'=> is_null($this->nutritional_info) ? '' : $this->nutritional_info,
            'nutritional_info_ar'=> is_null($this->nutritional_info_ar) ? '' : $this->nutritional_info_ar,
            'description' => is_null($this->description) ? '' : $this->description,
            'description_ar' => is_null($this->description_ar) ? '' : $this->description_ar,
            'offer' => is_null($this->offer) ? 0 : $this->offer,
            'color_code' => is_null($this->color_code) ? '' : $this->color_code,
            'created_at' => date('d-m-Y'),
            'updated_at' => date('d-m-Y'),
        ];
    }
    
}