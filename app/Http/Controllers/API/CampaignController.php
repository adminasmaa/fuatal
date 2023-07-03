<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Carbon\Carbon;
use Validator;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\Gift as GiftResource;
use App\Http\Resources\Lottery as LotteryResource;
use App\Http\Resources\Mekano as MekanoResource;
use App\Models\CompanyQuota;
use App\Models\CreditNumber;
use App\Models\Mekano;
use App\Models\Stick;
use App\Models\Gift;
use App\Models\Lottery;
use App\Models\TelCompany;
use App\Models\User;
use App\Models\WinnerSettingDateTime;
use DateTime;
use DateTimeZone;

class CampaignController extends BaseController
{

    public function index()
    {
        $Articles = Article::all();
        return $this->sendResponse(ArticleResource::collection($Articles), 'Posts fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();



        $validator = Validator::make($input, [
            'image' => 'required',
            'user_id' => 'required',
            'no_sticks' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }


        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $qnames = $file->getClientOriginalName();
            $image['filePath'] = $qnames;
            $file->move(public_path() . '/uploads/categories/', $qnames);
            $qname = $qnames;
        }

        Mekano::insert(['no_sticks' => $input['no_sticks'], 'user_id' => $input['user_id'], 'image' => $qname]);

        return response()->json(['success' => true, 'message' => 'Data added!']);
    }


    public function show($id)
    {
        $Article = Article::find($id);
        if (is_null($Article)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new ArticleResource($Article), 'Post fetched.');
    }


    public function update(Request $request, Article $Article)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }


        if ($request->hasfile('recipe_image')) {
            $file = $request->file('recipe_image');
            $qnames = $file->getClientOriginalName();
            $image['filePath'] = $qnames;
            $file->move(public_path() . '/uploads/categories/', $qnames);
            $qname = $qnames;
        }

        $Article->title = $input['title'];
        $Article->description = $input['description'];
        $Article->trans_status = 1;
        $Article->lang_name = 'English';
        $Article->save();
        //$Article->trans_id=>$latestObj->id


        Article::where('id', $Article->id)->update(['trans_id' => $Article->id]);

        return $this->sendResponse(new ArticleResource($Article), 'Post updated.');
    }

    public function destroy(Article $Article)
    {
        $Article->delete();
        return $this->sendResponse([], 'Post deleted.');
    }

    public function getUserGifts($id)
    {
        $per_page = 10;
        $gifts = Lottery::where('user_id', $id)->where('type', 'gift')->where('win_status', 1)->orderby('winning_date', 'desc')->paginate($per_page);
        return response()->json([
            "success" => true,
            'total_count' => $gifts->total(),
            "data" => GiftResource::collection($gifts),
            "message" => "Data fetched."
        ]);
    }

    public function getUserAllGifts($id)
    {
        $per_page = 10;
        $gifts = Lottery::where('user_id', $id)->orderby('created_at', 'desc')->paginate($per_page);
        return response()->json([
            "success" => true,
            'total_count' => $gifts->total(),
            "data" => GiftResource::collection($gifts),
            "message" => "Data fetched."
        ]);
    }

    public function getUserLotteries($id)
    {
        $per_page = 10;
        $lotteries = Lottery::where('user_id', $id)->where('type', 'lottery')->where('win_status', 1)->orderby('winning_date', 'desc')->paginate($per_page);
        return response()->json([
            "success" => true,
            'total_count' => $lotteries->total(),
            "data" => LotteryResource::collection($lotteries),
            "message" => "Data fetched."
        ]);
    }

    public function getUserMekanos($id)
    {
        $per_page = 10;
        $mekanos = Mekano::where('user_id', $id)->orderby('created_at', 'desc')->paginate($per_page);
        return response()->json([
            "success" => true,
            'total_count' => $mekanos->total(),
            "data" => MekanoResource::collection($mekanos),
            "message" => "Data fetched."
        ]);
    }

    public function getWinningMekanos($id)
    {
        $per_page = 10;
        $mekanos = Mekano::where('user_id', $id)->where('win_status', 1)->orderby('winning_date', 'desc')->paginate($per_page);
        return response()->json([
            "success" => true,
            'total_count' => $mekanos->total(),
            "data" => MekanoResource::collection($mekanos),
            "message" => "Data fetched."
        ]);
    }

    public function allMekanosWinners($type, Request $request)
    {
        $type_ = 'all';
        $per_page = 10;
        if (isset($type) && $type != "") {
            $type_ = $type;
        }
        if ($type_ == 'all') {
            $mekanos = Mekano::where('win_status', 1)->orderby('winning_date', 'desc')->paginate($per_page);
        } else if ($type == 'winners') {
            $mekanos = Mekano::where('win_status', 1)->whereHas('user', function ($query) {
                $query->where('role_id', '0');
            })->orderby('winning_date', 'desc')->paginate($per_page);
        } else if ($type == 'admin') {
            $mekanos = Mekano::where('win_status', 1)->whereHas('user', function ($query) {
                $query->where('role_id', '!=', '0');
            })->orderby('winning_date', 'desc')->paginate($per_page);
        } else {
            return response()->json(['success' => true, 'total_count' => 0, 'data' => []], 200);
        }
        return response()->json(['success' => true, 'total_count' => $mekanos->total(), 'data' => MekanoResource::collection($mekanos)], 200);
    }

    public function getNewNotifications($user_id)
    {
        $gift_type = 'gift';
        $lottery_type = 'lottery';
        $mekano_type = 'mekano';
        $data = [];
        $gifts = Lottery::where('user_id', $user_id)->where('type', 'gift')->where('seen', 0)->where('win_status', 1)->count();
        $lotteries = Lottery::where('user_id', $user_id)->where('type', 'lottery')->where('seen', 0)->where('win_status', 1)->count();
        $mekanos = Mekano::where('user_id', $user_id)->where('seen', 0)->where('win_status', 1)->count();
        return response()->json(['success' => true, 'gift_count' => $gifts, 'lottery_count' => $lotteries, 'mekano_count' => $mekanos, 'total_count' => $gifts + $lotteries + $mekanos], 200);
    }
    public function getAllNotifications($user_id)
    {
        $gift_type = 'gift';
        $lottery_type = 'lottery';
        $mekano_type = 'mekano';
        $data = [];
        $gifts = Lottery::where('user_id', $user_id)->where('type', 'gift')->where('win_status', 1)->get();
        $lotteries = Lottery::where('user_id', $user_id)->where('type', 'lottery')->where('win_status', 1)->get();
        $mekanos = Mekano::where('user_id', $user_id)->where('win_status', 1)->get();
        if (count($gifts) || count($lotteries) || count($mekanos)) {
            $data['gift'] = $gifts;
            $data['lottery'] = $lotteries;
            $data['mekano'] = $mekanos;
            return response()->json(['success' => true, 'gift_count' => count($gifts), 'lottery_count' => count($lotteries), 'mekano_count' => count($mekanos), 'total_count' => count($gifts) + count($lotteries) + count($mekanos), 'data' => $data], 200);
        } else {
            return response()->json(['success' => true, 'gift_count' => 0, 'lottery_count' => 0, 'mekano_count' => 0, 'total_count' => 0, 'data' => []], 200);
        }
    }
    public function setNotifications($user_id, $type)
    {
        if ($type == 'gift') {
            $gifts = Lottery::where('user_id', $user_id)->where('type', 'gift')->where('win_status', 1)->where('seen', 0)->update(['seen' => 1]);
        } elseif ($type == 'lottery') {
            $lotteries = Lottery::where('user_id', $user_id)->where('type', 'lottery')->where('win_status', 1)->where('seen', 0)->update(['seen' => 1]);
        } elseif ($type == 'mekano') {
            $mekanos = Mekano::where('user_id', $user_id)->where('win_status', 1)->where('seen', 0)->update(['seen' => 1]);
        }
        return response()->json(['success' => true, 'message' => 'Updated'], 200);
    }

    public function getSticks()
    {
        $sticks = Stick::orderby('updated_at', 'desc')->get();
        return response()->json([
            "success" => true,
            'total_count' => $sticks->count(),
            "data" => $sticks,
            "message" => "Data fetched."
        ]);
    }

    public function assignCode(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        if (!$user) {
            return response()->json(['success' => true, 'code' => 404, 'message' => 'User not found', 'type' => "", 'credit_number' => ""]);
        }
        if (!$user->is_active) {
            return response()->json(['success' => true, 'code' => 500, 'message' => 'User is inactive', 'type' => "", 'credit_number' => ""]);
        }
        $code = $request->code;
        $gift = Lottery::where('random_number', $code)->first();
        if ($gift) {
            if ($gift->user_id != 0) {
                if ($gift->user_id == $user_id)
                    return response()->json(['success' => true, 'code' => 500, 'message' => 'QR code already scanned', 'type' => $gift->type, 'credit_number' => ""]);
                else
                    return response()->json(['success' => true, 'code' => 500, 'message' => 'QR code already assigned to other user', 'type' => $gift->type, 'credit_number' => ""]);
            } else {
                $gift->user_id = $user_id;
                $gift->scan_date = Carbon::now();
                if ($gift->type == 'gift') {
                    if ($gift->bundle->package->end_date < Carbon::now()) {
                        return response()->json([
                            'success' => true,
                            'status' => 500,
                            'message' => 'QR code expired',
                            'type' => $gift->type,
                            'credit_number' => ""
                        ]);
                    } else {
                        $prefix = substr($user->phone, 2, 3);
                        $company_data = TelCompany::where('prefix', $prefix)->first();
                        if ($company_data) {
                            $company_quota = CompanyQuota::where('company_id', $company_data->id)->where('to', '>=', now())->whereRaw('qouta-used > 0')->first();
                        }
                        if (isset($company_quota) && $company_quota) {
                            $cr_no = CreditNumber::where('tel_company_id', $company_data->id)->where('expired', 0)->first();
                            if ($cr_no) {
                                $company_quota->used = $company_quota->used + 1;
                                $company_quota->save();
                                $gift->credit_number = $cr_no->number;
                                $cr_no->expired = 1;
                                $cr_no->save();
                            }
                        }
                        $gift->win_status = true;
                        $gift->winning_date = new \DateTime();
                    }
                }
                $gift->save();
                return response()->json(['success' => true, 'code' => 200, 'message' => 'QR code saved successfully', 'type' => $gift->type, 'credit_number' => is_null($gift->credit_number) ? '' : $gift->credit_number]);
            }
        } else {
            return response()->json(['success' => true, 'code' => 500, 'message' => 'QR code not found in our system', 'type' => "", 'credit_number' => ""]);
        }
    }

    public function getGiftsLotteries($user_id, $type, Request $request)
    {
        $per_page = 10;
        if ($type == 'all') {
            $winners = Lottery::where('win_status', 1)->where('user_id', $user_id)->orderby('winning_date', 'desc')->paginate();
            return response()->json([
                "success" => true,
                'total_count' => $winners->total(),
                "data" => LotteryResource::collection($winners),
                "message" => "Data fetched."
            ]);
        } elseif ($type == 'gift') {
            $winners = Lottery::where('win_status', 1)->where('user_id', $user_id)->where('type', 'gift')->orderby('winning_date', 'desc')->paginate();
            return response()->json([
                "success" => true,
                'total_count' => $winners->total(),
                "data" => LotteryResource::collection($winners),
                "message" => "Data fetched."
            ]);
        } elseif ($type == 'lottery') {
            $winners = Lottery::where('win_status', 1)->where('user_id', $user_id)->where('type', 'lottery')->orderby('winning_date', 'desc')->paginate();
            return response()->json([
                "success" => true,
                'total_count' => $winners->total(),
                "data" => LotteryResource::collection($winners),
                "message" => "Data fetched."
            ]);
        } else {
            return response()->json([
                'success' => true,
                'total_count' => 0,
                'data' => [],
                'message' => 'Data fetched'
            ]);
        }
    }
    public function getBusinessMessages(Request $request)
    {
        $message = 'Thankyou for participating, We will get back to you Soon.';
        $data = $request->all();
        // create a $dt object with the UTC timezone
        $dt = new DateTime($data['timestamp'], new DateTimeZone('UTC'));

        // change the timezone of the object without changing its time
        $dt->setTimezone(new DateTimeZone('Asia/Baghdad'));

        // \Log::Info($data);
        // die;
        $number = substr($data['from'], -10);
        $phone_code = substr($number, 0, 2);
        $phone_code = '0' . $phone_code;
        \Log::Info($phone_code);
        if ($data['text']) {
            $qr_code = $data['text'];
            if (!$qr_code) {
                $message = 'Please send correct format, This format is not valid.';
            } else {
                $lottery = Lottery::where('random_number', $qr_code)->first();
                if ($lottery) {
                    if (is_null($lottery->phone_number)) {
                        $lottery->customer_json = json_encode($data);
                        $lottery->scan_date = $dt->format('Y-m-d H:i:s');
                        $time = $dt->format('H:i:s');
                        $winner_setting = WinnerSettingDateTime::whereTime('start_time', '<=', $time)
                            ->whereTime('end_time', '>=', $time)
                            ->whereHas('setting', function ($sq) use ($dt) {
                                $sq->whereDate('start_date', '<=', $dt->format('Y-m-d'));
                                $sq->whereDate('end_date', '>=', $dt->format('Y-m-d'));
                            })->first();
                        if ($winner_setting) {
                            $json_Array = json_decode($winner_setting->json_array);
                            if ($json_Array[$winner_setting->winner_out_of - $winner_setting->remaining] == 'w') {
                                \Log::Info($json_Array[$winner_setting->winner_out_of - $winner_setting->remaining]);
                                $credit_number = CreditNumber::whereHas('company', function ($sq) use ($phone_code) {
                                    $sq->where('prefix', $phone_code);
                                })->where('expired', 0)->whereDate('expire_date', '>', Carbon::now('Asia/Baghdad'))->first();
                                if ($credit_number) {
                                    $lottery->win_status = 1;
                                    $lottery->winning_date = now();
                                    $lottery->credit_number = $credit_number->number;
                                    $credit_number->expired = 1;
                                    $credit_number->save();
                                    $message = 'Congratulations! You are a winner and your winning recharge code is: ' . $credit_number->number;
                                } else {
                                    $message = 'Better Luck for next time, as Credit numbers not available for this time';
                                }
                            } else {
                                $message = 'Better Luck for next time, You cannot win for this time';
                            }
                            $remaining = $winner_setting->remaining - 1;
                            if ($remaining == 0) {
                                $array_ = [];
                                for ($i = 0; $i < $winner_setting->no_winners; $i++) {
                                    $array_[$i] = 'w';
                                }
                                if ($winner_setting->winner_out_of - $winner_setting->no_winners > 0) {
                                    for ($i = $winner_setting->no_winners; $i < $winner_setting->winner_out_of; $i++) {
                                        $array_[$i] = 'l';
                                    }
                                }
                                shuffle($array_);
                                $winner_setting->remaining = $winner_setting->winner_out_of;
                                $winner_setting->json_array = json_encode($array_);
                                $winner_setting->save();
                            } else {
                                $winner_setting->remaining  = $remaining;
                                $winner_setting->save();
                            }
                        } else {
                            $message = 'Better Luck for Next Time, You are too late';
                            \Log::Info('Not found setting');
                        }
                        $lottery->phone_number = isset($data['from']) ? $data['from'] : '';
                        $lottery->phone_code = isset($data['from']) && $phone_code ? $phone_code : '';
                        $lottery->customer_name = isset($data['profile']) && isset($data['profile']['name']) ? $data['profile']['name'] : '';
                        $lottery->save();
                    } else {
                        $message = 'This Code has already sent.';
                    }
                } else {
                    $message = 'This Code is not found in our system, Please try again';
                }
            }
        } else {
            $message = 'Please send correct format, This format is not valid.';
        }
        $sent_ = $this->sendBusinessMessage($data['from'], $message);
        \Log::Info($sent_);
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
