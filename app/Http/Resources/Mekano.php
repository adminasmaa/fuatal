<?php
  
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class Mekano extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'image' =>asset('uploads/categories/'. $this->image),
            'winning_date' => is_null($this->winning_date) ? "" : date('d-m-Y', strtotime($this->winning_date)),
            'winning_status' => $this->win_status,
            'user' => $this->user
        ];
    }
    
}