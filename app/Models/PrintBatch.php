<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_id', 'end_id', 'total_files'
    ];

    public function files()
    {
        return $this->hasMany(PrintBatchFile::class, 'print_batch_id', 'id');
    }
}
