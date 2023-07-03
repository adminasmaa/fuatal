<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'tel_company_id', 'credit_amount', 'expire_date', 'number', 'created_at', 'updated_at', 'expired'
    ];

    public function company()
    {
        return $this->belongsTo(\App\Models\TelCompany::class, 'tel_company_id');
    }
}
