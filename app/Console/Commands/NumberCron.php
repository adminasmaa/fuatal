<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Gift;
use App\Models\Lottery;

class NumberCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'number:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Barcodes and QRcodes for random numbers in DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // update gifts
        // $gifts = Gift::where(function ($query){
        //     $query->where('bar_code', '=', NULL)
        //     ->orWhereNull('qr_code', '=', NULL);
        // })->orderby('id', 'desc')->get();

        // if(count($gifts))
        // {
        //     foreach($gifts as $gift)
        //     {
        //         $random = $gift->random_number;
        //         if(is_null($gift->bar_code))
        //         {
        //             $barcode_name = $random.'_barcode.png';
        //             $path_barcode = public_path('/uploads/barcodes/gifts');
        //             File::isDirectory($path_barcode) or File::makeDirectory($path_barcode, 0777, true, true);
        //             file_put_contents($path_barcode.'/'.$barcode_name, base64_decode(\DNS2D::getBarcodePNG($random, 'QRCODE', 10, 10)));
        //             $gift->bar_code = $barcode_name;
        //         }
        //         if(is_null($gift->qr_code))
        //         {
        //             $qrcode_name = $random.'_qr.png';
        //             $path_qrcode = public_path('/uploads/qrcodes/gifts');
        //             File::isDirectory($path_qrcode) or File::makeDirectory($path_qrcode, 0777, true, true);
        //             file_put_contents($path_qrcode.'/'.$qrcode_name, base64_decode(\DNS1D::getBarcodePNG($random, 'C39', 2, 100)));
        //             $gift->qr_code = $qrcode_name;
        //         }
        //         $gift->save();
        //     }
        // }

        // Update Lotteries
        $lotteries = Lottery::where(function ($query) {
            $query->where('bar_code', '=', NULL)
                ->orWhereNull('qr_code', '=', NULL);
        })->orderby('id', 'desc')->get();
        if (count($lotteries)) {
            foreach ($lotteries as $lottery) {
                $random = $lottery->random_number;
                if (is_null($lottery->qr_code)) {
                    $qrcode_name = $random . '_qr.png';
                    $path_barcode = public_path('/uploads/qrcodes/lotteries');
                    File::isDirectory($path_barcode) or File::makeDirectory($path_barcode, 0777, true, true);
                    if ($lottery->type == 'telecom') {
                        $business_number = env('BUSINESS_NUMBER', '14157386102');
                        file_put_contents($path_barcode . '/' . $qrcode_name, base64_decode(\DNS2D::getBarcodePNG("https://www.fustekaice.com/app", 'QRCODE', 10, 10)));
                    } else {
                        file_put_contents($path_barcode . '/' . $qrcode_name, base64_decode(\DNS2D::getBarcodePNG($random, 'QRCODE', 10, 10)));
                    }
                    $lottery->qr_code = $qrcode_name;
                }
                if (is_null($lottery->bar_code)) {
                    $barcode_name = $random . '_barcode.png';
                    $path_qrcode = public_path('/uploads/barcodes/lotteries');
                    File::isDirectory($path_qrcode) or File::makeDirectory($path_qrcode, 0777, true, true);
                    file_put_contents($path_qrcode . '/' . $barcode_name, base64_decode(\DNS1D::getBarcodePNG($random, 'C39', 2, 100)));
                    $lottery->bar_code = $barcode_name;
                }
                $lottery->save();
            }
        }
    }
}
