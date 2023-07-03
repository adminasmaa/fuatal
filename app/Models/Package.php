<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'start_date', 
        'end_date', 
        'status'
     ]; 

    public function bundles()
    {
        return $this->hasMany(\App\Models\Bundle::class, 'package_id', 'id');
    }
}
