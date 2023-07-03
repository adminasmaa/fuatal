<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinnerSettingGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'winner_setting_id', 'limit', 'status'
    ];

    public function setting()
    {
        return $this->belongsTo(WinnerSetting::class);
    }

    public function lotteries()
    {
        return $this->hasMany(Lottery::class, 'winner_setting_group_id', 'id');
    }
}
