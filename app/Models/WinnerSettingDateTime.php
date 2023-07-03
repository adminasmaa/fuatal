<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinnerSettingDateTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'winner_setting_date_id', 'winner_setting_id', 'start_time', 'end_time', 'no_winners', 'winner_out_of', 'remaining', 'json_array'
    ];

    public function setting()
    {
        return $this->belongsTo(WinnerSetting::class, 'winner_setting_id', 'id');
    }
}
