<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintBatchFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_id', 'end_id', 'file_name', 'print_batch_id'
    ];

    public function batch()
    {
        return $this->belongsTo(PrintBatch::class, 'print_batch_id', 'id');
    }
}
