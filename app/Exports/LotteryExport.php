<?php

namespace App\Exports;

use App\Models\Lottery;
use App\Models\PrintBatch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LotteryExport implements FromCollection, WithMapping, WithHeadings
{

    protected $type;

    function __construct($type = 'all')
    {
        $this->type = $type;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->type == 'gift' || $this->type == 'lottery') {
            return Lottery::where('user_id', 0)->where('type', $this->type)->with('user')->with('product')->with('bundle')->orderby('created_at', 'desc')->orderby('id', 'desc')->get();
        } elseif ($this->type == 'telecom') {
            $min = 0;
            $max = 0;
            $min_value = PrintBatch::min('start_id');
            $max_value = PrintBatch::max('end_id');
            if ($min_value) {
                $min = $min_value;
            }
            if ($max_value) {
                $max = $max_value;
            }
            return Lottery::where('user_id', 0)->when($max > 0 && $min > 0, function ($mq) use ($min, $max) {
                $mq->where('id', '<', $min)
                    ->orWhere('id', '>', $max);
            })->where('type', $this->type)->with('product')->orderby('created_at', 'desc')->orderby('id', 'desc')->get();
        } else {
            return Lottery::where('user_id', 0)->with('user')->with('product')->with('bundle')->orderby('created_at', 'desc')->get();
        }
    }

    public function map($lottery): array
    {
        return [
            $lottery->id,
            $lottery->random_number,
            $lottery->type,
            is_null($lottery->qr_code) ? "" : asset('uploads/qrcodes/lotteries/' . $lottery->qr_code)
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Code Number',
            'Type',
            'QR Code',
        ];
    }
}
