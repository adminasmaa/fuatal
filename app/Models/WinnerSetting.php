<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinnerSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_winners', 'winner_out_of', 'start_date_time', 'end_date_time', 'status', 'start_date', 'end_date'
    ];

    public function groups()
    {
        return $this->hasMany(WinnerSettingGroup::class);
    }
    
    public function times()
    {
        return $this->hasMany(WinnerSettingDateTime::class, 'winner_setting_id', 'id');
    }
}
