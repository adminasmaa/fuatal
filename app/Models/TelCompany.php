<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'prefix', 'logo', 'created_at', 'updated_at'
    ];

    public function numbers()
    {
        return $this->hasMany(\App\Models\CreditNumber::class, 'tel_company_id', 'id');
    }

    public function quotas()
    {
        return $this->hasMany(\App\Models\CompanyQuota::class, 'company_id', 'id');
    }

    public function lotteries()
    {
        return $this->hasMany(Lottery::class, 'phone_code', 'prefix');
    }

    // public function availableCount() {
    //     $total_numbers = $this->numbers()->where('expired', 0)->count();
    //     $quotas = $this->quotas()->where('active', 1)->count();
    //     return $total_numbers - $quotas;
    //     // return $this->numbers()->where('expired',0)->get();
    // }
}
