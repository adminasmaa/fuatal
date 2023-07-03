<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stick extends Model
{
    use HasFactory;
    protected $fillable = [
        'from','to','range','created_at','updated_at'
     ];

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mekanos()
    {
        return $this->hasMany(\App\Models\Mekano::class, 'no_sticks', 'id');
    }
}
