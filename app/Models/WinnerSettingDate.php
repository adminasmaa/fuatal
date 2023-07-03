<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinnerSettingDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'winner_setting_id', 'date'
    ];

    public function setting()
    {
        return $this->belongsTo(WinnerSetting::class);
    }
}
