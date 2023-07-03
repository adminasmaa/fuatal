<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyQuota extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'from', 'to', 'qouta', 'used', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
