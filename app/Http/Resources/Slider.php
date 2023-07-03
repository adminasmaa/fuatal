<?php
  
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class Slider extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' =>asset('uploads/sliders/'. $this->image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    
}