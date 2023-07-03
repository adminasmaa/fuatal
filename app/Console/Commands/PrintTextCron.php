<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Gift;
use App\Models\Lottery;
use App\Models\PrintBatch;
use App\Models\PrintBatchFile;
use Illuminate\Support\Facades\Storage;

class PrintTextCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'printtext:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Text files and store';

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
        \Log::Info('in text print cron job');
        $batches = PrintBatch::all();
        if ($batches) {
            foreach ($batches as $batch) {
                if (isset($batch->files) && count($batch->files)) {
                    if (count($batch->files) < $batch->total_files) {
                    }
                } else {
                    // prepare content
                    $content = "";
                    // $zip_file = date('d-m-Y', strtotime($batch->created_at)) . '_' . $batch->id . '.zip'; // Name of our archive to download

                    // // Initializing PHP class
                    // $zip = new \ZipArchive();

                    // Adding file: second parameter is what will the path inside of the archive
                    // So it will create another folder called "storage/" inside ZIP, and put the file there.
                    $content = "";
                    for ($i = 1; $i <= $batch->total_files; $i++) {

                        // $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
                        $numbers = Lottery::where('type', 'telecom')
                            ->where('id', '>=', $batch->start_id)
                            ->where('id', '<=', $batch->end_id)
                            ->orderby('created_at', 'desc')
                            ->skip(($i - 1) * 10000)
                            ->take(10000)->get();
                        \Log::Info(count($numbers));
                        // $count_ = 1;
                        foreach ($numbers as $number) {
                            // if($count_ == 1)
                            // {
                            //     $start_
                            // }
                            $content .= $number->random_number . "\r\n";
                        }
                    }
                    $fileName = date('d-m-Y', strtotime($batch->created_at)) . '_' . $batch->id . '.' . $i . '.txt';
                    $file_created = PrintBatchFile::create([
                        'print_batch_id' => $batch->id,
                        'file_name' => $fileName,
                        'start_id' => 1,
                        'end_id' => 1
                    ]);
                    $path = public_path('uploads/textfiles/' . $batch->id . '/' . $fileName);
                    if (!File::isDirectory(public_path('uploads/textfiles'))) {
                        File::makeDirectory(public_path('uploads/textfiles'));
                    }
                    if (!File::isDirectory(public_path('uploads/textfiles/' . $batch->id))) {
                        File::makeDirectory(public_path('uploads/textfiles/' . $batch->id));
                    }
                    if (file_put_contents($path, $content)) {
                        // $zip->addFile(public_path('uploads/textfiles/' . $batch->id . '/' . $fileName), $fileName);
                        // $zip->close();
                    }
                    // $path_ = public_path('uploads/textfiles/' . $batch->id . '/' . $zip_file);
                    // if (!File::isDirectory(public_path('uploads/textfiles/' . $batch->id))) {
                    //     File::makeDirectory(public_path('uploads/textfiles/' . $batch->id));
                    // }
                    // file_put_contents($path_, $zip_file);
                }
            }
        }
    }
}
