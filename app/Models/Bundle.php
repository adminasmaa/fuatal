<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'status', 
        'package_id',
        'limit'
     ]; 

    public function package()
    {
        return $this->belongsTo(\App\Models\Package::class, 'package_id');
    }
    public function lotteries()
    {
        return $this->hasMany(\App\Models\Lottery::class, 'bundle_id', 'id');
    }
}
