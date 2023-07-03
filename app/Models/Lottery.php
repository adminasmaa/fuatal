<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lotteries';
    protected $fillable = [
        'winner_setting_group_id'
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function bundle()
    {
        return $this->belongsTo(\App\Models\Bundle::class, 'bundle_id');
    }

    public function group()
    {
        return $this->belongsTo(WinnerSettingGroup::class, 'winner_setting_group_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(TelCompany::class, 'phone_code', 'prefix');
    }
}
