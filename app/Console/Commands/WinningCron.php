<?php

namespace App\Console\Commands;

use App\Models\CreditNumber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Lottery;
use App\Models\WinnerSetting;
use App\Models\WinnerSettingGroup;

class WinningCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'winning:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Winners by the winner settings';

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
        $settings = WinnerSetting::all();
        if ($settings) {
            foreach ($settings as $setting) {
                $lottery_query = Lottery::where('type', 'telecom')
                    ->whereNotNull('phone_number')
                    ->whereHas('company')
                    ->WhereDoesntHave('group')
                    ->where('scan_date', '<=', $setting->end_date_time)
                    ->where('scan_date', '>=', $setting->start_date_time)
                    ->where('win_status', 0)
                    ->orderby('scan_date', 'asc');
                $total_count = $lottery_query->count();
                if ($total_count) {
                    $group = WinnerSettingGroup::where('winner_setting_id', $setting->id)->where('status', 1)->latest()->first();
                    if ($group) {
                        $remaining = $setting->winner_out_of - count($group->lotteries);
                        if ($remaining > 0) {
                            $lottery_query->skip(0)->take($remaining)->update([
                                'winner_setting_group_id' => $group->id
                            ]);
                        }
                    }
                    $loop_ = true;
                    while ($loop_ == true) {
                        \Log::Info('In loop');
                        $lotteries = $lottery_query->skip(0)->take($setting->winner_out_of)->get();
                        \Log::Info($lotteries->count());
                        if ($lotteries->count() > 0) {
                            \Log::Info($lotteries->count());
                            \Log::Info($loop_);
                            $new_group = WinnerSettingGroup::create([
                                'winner_setting_id' => $setting->id,
                                'limit' => $setting->winner_out_of
                            ]);
                            foreach ($lotteries as $lottery) {
                                $lottery->update([
                                    'winner_setting_group_id' => $new_group->id
                                ]);
                            }
                        } else {
                            $loop_ = false;
                        }
                    }
                }
                $setting_groups = WinnerSettingGroup::where('winner_setting_id', $setting->id)->where('status', 1)->get();
                if ($setting_groups) {
                    \Log::Info('yes in running winning algorithm');
                    foreach ($setting_groups as $sgroup) {
                        $current_date_time = date('Y-m-d h:i:s');
                        if ($setting->end_date_time <= $current_date_time && count($sgroup->lotteries) <= $setting->no_winners && count($sgroup->lotteries) > 0) {
                            foreach ($sgroup->lotteries as $winner) {
                                $credit_number = CreditNumber::where('expired', 0)->whereHas('company', function ($sq) use ($winner) {
                                    $sq->where('prefix', $winner->phone_code);
                                })->first();
                                if ($credit_number) {
                                    $winner->win_status = true;
                                    $winner->winning_date = now();
                                    $winner->credit_number = $credit_number->number;
                                    $winner->save();
                                    $credit_number->expired = 1;
                                    $credit_number->save();
                                    $message = 'Congratulations, You are a winner and your Credit Number is: ' . $credit_number->number;
                                    $sent_ = $this->sendBusinessMessage($winner->phone_number, $message);
                                } else {
                                    \Log::Info('credit number not found');
                                    \Log::Info($sgroup->lotteries);
                                    \Log::Info($winner->phone_code);
                                }
                            }
                        } else {
                            if (($setting->end_date_time <= $current_date_time) || (count($sgroup->lotteries) >= $setting->winner_out_of)) {
                                $lotteries = Lottery::whereHas('group', function ($sq) use ($sgroup) {
                                    $sq->where('winner_setting_group_id', $sgroup->id);
                                    $sq->where('status', 1);
                                })->inRandomOrder()->skip(0)->take($setting->no_winners)->get();
                                if ($lotteries) {
                                    foreach ($lotteries as $winner) {
                                        $credit_number = CreditNumber::where('expired', 0)->whereHas('company', function ($sq) use ($winner) {
                                            $sq->where('prefix', $winner->phone_code);
                                        })->first();
                                        if ($credit_number) {
                                            $winner->win_status = true;
                                            $winner->winning_date = now();
                                            $winner->credit_number = $credit_number->number;
                                            $winner->save();
                                            $credit_number->expired = 1;
                                            $credit_number->save();
                                            $message = 'Congratulations, You are a winner and your Credit Number is: ' . $credit_number->number;
                                            $sent_ = $this->sendBusinessMessage($winner->phone_number, $message);
                                        } else {
                                            \Log::Info('credit number not found');
                                            \Log::Info($lotteries);
                                            \Log::Info($winner->phone_code);
                                        }
                                    }
                                    $non_winners = Lottery::whereHas('group', function ($sq) use ($sgroup) {
                                        $sq->where('winner_setting_group_id', $sgroup->id);
                                        $sq->where('status', 1);
                                    })->where('win_status', 0)->get();
                                    if ($non_winners) {
                                        foreach ($non_winners as $non_winner) {
                                            $sent_ = $this->sendBusinessMessage($non_winner->phone_number, 'Better Luck for the Next Time, Thankyou for participating.');
                                        }
                                    }
                                }
                            }
                        }
                        $sgroup->status = 0;
                        $sgroup->save();
                    }
                }
            }
        }
    }

    public function sendBusinessMessage($to, $message)
    {
        $url = "https://messages-sandbox.nexmo.com/v1/messages";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Basic Y2E3ZjM5Y2U6MDc2TmFBc0tNV200YUQzYQ==",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = json_encode([
            "from" => env('BUSINESS_NUMBER'),
            "to" => $to,
            "message_type" => "text",
            "text" => $message,
            "channel" => "whatsapp"
        ]);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        // if ($resp->message_uuid) {
        //     return response()->json([
        //         'success' => true,
        //         'response' => $resp

        //     ]);
        // } else {
        return response()->json([
            'success' => true,
            'response' => $resp
        ]);
        // }
    }
}
