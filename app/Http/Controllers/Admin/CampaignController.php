<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Http\Controllers\Admin\DataTables\PageDataTable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Exports\LotteryExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use DateTime;
use App\Models\Page;
use Storage;
use Illuminate\Http\Request;
use App\Models\Bundle;
use App\Models\Gift;
use App\Models\Mekano;
use App\Models\Stick;
use App\Models\Lottery;
use App\Models\User;
use App\Models\Product;
use App\Models\Package;
use App\Models\PrintBatch;
use App\Models\PrintBatchFile;
use App\Models\TelCompany;
use App\Models\WinnerSetting;
use App\Models\WinnerSettingDate;
use App\Models\WinnerSettingDateTime;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\View;
use PDF;

class CampaignController extends AdminController
{
    /**
     * @var array
     */
    protected $validation = [
        'content'     => 'required|string',
        'parent_id'   => 'nullable|integer',
        'description' => 'required|string|max:200',
        'title'       => 'required|string|max:200'
    ];

    /**
     * @param \App\Http\Controllers\Admin\DataTables\PageDataTable $dataTable
     *
     * @return mixed
     */
    public function index()
    {
        for ($i = 1; $i <= 1000; $i++) {
            sleep(1);
            $random = substr(sha1(time()), 0, 7);
            Gift::insert([
                'random_number' => strtoupper($random),

            ]);
        }

        // return $dataTable->render('admin.table', ['link' => route('admin.page.create')]);
    }

    public function lotteryGiftListing()
    {
        if (Auth::user()->hasPermission('view_gift_campaign')) {
            $giftListing = Gift::all();
            return view('admin.gift-campaign-listing', compact('giftListing'));
        } else {
            return view('admin.access_denied');
        }
    }

    public function mekanoWinnerListing()
    {
        if (Auth::user()->hasPermission('view_gift_campaign')) {
            $mekanos = Mekano::orderby('created_at', 'desc')->paginate(3);
            // $userObj=User::select('users.*','mekanos.no_sticks','mekanos.id as mekano_id','mekanos.image','mekanos.win_status','mekanos.user_id')
            // ->join('mekanos', 'mekanos.user_id', '=', 'users.id')
            // ->orderby('mekanos.created_at', 'desc')->get();
            return view('admin.mekano-campaign-winner', compact('mekanos'));
            //return view('admin.mekano-campaign-listing',compact('giftListing'));
        } else {
            return view('admin.access_denied');
        }
    }
    public function winnerSettings()
    {
        return view('admin.winner-settings');
    }
    public function winnersAjaxSettings(Request $request)
    {
        $winner_settings = [];
        $winner_settings = WinnerSetting::where('status', 1)->orderby('created_at', 'desc')->get();
        return View::make('admin.winnersAjax', ['success' => true, 'winner_settings' => $winner_settings, 'errors' => [], 'request' => []]);
    }
    public function saveWinnerSettings(Request $request)
    {
        $winner_settings = WinnerSetting::where('status', 1)->get();
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        if ($validator->fails()) {
            return View::make('admin.winnersAjax', ['success' => false, 'errors' => $validator->errors()->getMessages(), 'winner_settings' => $winner_settings, 'request' => $request]);
        }
        $found = WinnerSetting::where('start_date', '<=', $request->end_date)
            ->where('end_date', '>=', $request->start_date)->first();
        if ($found) {
            $error[] = 'Winner Setting is already added with in this duration';
            return View::make('admin.winnersAjax', ['success' => false, 'errors' => ['server_error' => $error], 'winner_settings' => $winner_settings, 'request' => $request]);
        }
        $setting = WinnerSetting::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        // if ($setting) {
        //     $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
        //     $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);

        //     $dateRange = CarbonPeriod::create($startDate, $endDate);

        //     $dates = array_map(fn ($date) => $date->format('Y-m-d'), iterator_to_array($dateRange));
        //     if ($dates) {
        //         foreach ($dates as $date) {
        //             WinnerSettingDate::create([
        //                 'winner_setting_id' => $setting->id,
        //                 'date' => $date
        //             ]);
        //         }
        //     }
        // }
        $winner_settings = WinnerSetting::where('status', 1)->orderby('created_at', 'desc')->get();
        if ($setting) {
            return View::make('admin.winnersAjax', ['success' => true, 'errors' => [], 'winner_settings' => $winner_settings, 'request' => []]);
        } else {
            $error[] = 'Something went wrong, Please try again';
            return View::make('admin.winnersAjax', ['success' => false, 'errors' => ['server_error' => $error], 'winner_settings' => $winner_settings, 'request' => $request]);
        }
    }

    public function deleteWinnerSetting(Request $request)
    {
        // $dates = WinnerSettingDate::where('winner_setting_id', $request->id)->get();
        // if ($dates) {
        //     foreach ($dates as $date) {
        //         WinnerSettingDateTime::where('winner_setting_date_id', $date->id)->delete();
        //         $date->delete();
        //     }
        // }
        WinnerSettingDateTime::where('winner_setting_id', $request->id)->delete();
        WinnerSetting::where('id', $request->id)->delete();
        $winner_settings = WinnerSetting::where('status', 1)->orderby('created_at', 'desc')->get();
        return View::make('admin.winnersAjax', ['success' => true, 'errors' => [], 'winner_settings' => $winner_settings, 'request' => []]);
    }

    public function participants(Request $request)
    {
        $limit = $request->limit ? $request->limit : 20;
        $companies = TelCompany::all();
        $products = Product::all();
        $types = [
            'looser' => 'Looser',
            'winner' => 'Winner'
        ];
        $participants = Lottery::when($request->company, function ($sub) use ($request) {
            $sub->where('phone_code', $request->company);
        })->when($request->product, function ($sub) use ($request) {
            $sub->where('product_id', $request->product);
        })->when($request->from_date, function ($sub) use ($request) {
            $sub->where('scan_date', '>=', $request->from_date);
        })->when($request->to_date, function ($sub) use ($request) {
            $sub->where('scan_date', '<=', $request->to_date);
        })->when($request->participant_type, function ($sub) use ($request) {
            if ($request->participant_type == 'winner') {
                $sub->whereNotNull('winning_date');
            } else {
                if ($request->participant_type == 'looser') {
                    $sub->whereNull('winning_date');
                }
            }
        })->where('type', 'telecom')->whereNotNull('phone_number')->orderby('scan_date', 'desc')->paginate($limit);
        return view('admin.participants', compact('participants', 'companies', 'products', 'types'));
    }
    public function printGiftListing()
    {
        $giftListing = Gift::all();
        return view('admin.print-gift-campaign-listing', compact('giftListing'));
    }
    public function lotteryPrinting(Request $request)
    {
        $limit = $request->limit ?? 10;
        $giftListing = Lottery::paginate($limit);
        // $invoice = PDF::loadView('admin.print-lottery-campaign-listing',['giftListing' => $giftListing]);
        // dd($invoice);
        //     return $invoice->stream();
        return view('admin.print-lottery-campaign-listing', compact('giftListing'));
    }
    public function giftWinner()
    {
        if (Auth::user()->hasPermission('make_gift_winner')) {
            $userCount = User::where('role_id', 0)->where('is_active', 1)->get();

            foreach ($userCount as  $item) {

                $obj1 = Gift::where('user_id', $item->id)->where('win_status', 0)->first();

                if (is_null($obj1)) {

                    $obj2 = Gift::where('user_id', 0)->where('win_status', 0)->first();

                    Gift::where('id', $obj2->id)->update(['user_id' => $item->id]);
                }
            }


            $userObj = User::select('users.*', 'gifts.random_number', 'gifts.win_status', 'gifts.user_id', 'gifts.qr_code')
                ->join('gifts', 'gifts.user_id', '=', 'users.id')
                ->get();


            return view('admin.gift-campaign-winner', compact('userObj'));
        } else {
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }


    public function lotteryWinner($package_id)
    {
        $package = Package::where('id', $package_id)->first();
        $lotteries = Lottery::where('user_id', '!=', 0)->where('win_status', 0)->where('scan_date', '>=', $package->start_date)->where('scan_date', '<=', $package->end_date)->get();
        return view('admin.lottery-campaign-winner', compact('lotteries', 'package'));
    }

    public function makeGiftWinner(Request $request)
    {

        //echo $request->random_number;exit;
        Gift::where('random_number', $request->random_number)->update([
            'win_status' => 1,
            'winning_date' => new \DateTime()
        ]);
    }

    public function assignInstant($package_id)
    {
        $package = Package::where('id', $package_id)->first();
        $bundle_count = 0;
        if ($package->bundles) {
            foreach ($package->bundles as $bundle) {
                $bundle_count = $bundle_count + ($bundle->limit - $bundle->assigned);
            }
        }
        $lottery_count = Lottery::where('user_id', 0)->where('win_status', 0)->where('type', 'lottery')->count();
        $max_limit = $bundle_count;
        if ($lottery_count < $bundle_count) {
            $max_limit = $lottery_count;
        }
        return view('admin.assign-instant', compact('max_limit', 'package'));
    }

    public function makeInstantWinner(Request $request)
    {
        $auto_winnersCount = $request->limit;
        $package = Package::where('id', $request->package_id)->first();
        $lotteries = Lottery::where('user_id', 0)->where('win_status', 0)->where('type', 'lottery')->inRandomOrder()->limit($auto_winnersCount)->get();
        $bundles_arr = [];
        foreach ($package->bundles as $bundle) {
            $count_bundle = 0;
            $count_bundle = $count_bundle + ($bundle->limit - $bundle->assigned);
            if ($count_bundle > 0) {
                for ($i = 1; $i <= $count_bundle; $i++) {
                    $bundles_arr[] = $bundle->id;
                }
            }
        }
        foreach ($lotteries as $lottery) {
            $bndl = Arr::random($bundles_arr, 1);
            if ($bndl) {
                $lottery->win_status = 1;
                $lottery->type = 'gift';
                $lottery->bundle_id = $bndl[0];
                $lottery = $lottery->save();
                Bundle::where('id', $bndl[0])->update(['assigned' => \DB::raw('assigned+1')]);
            }
        }
        return redirect()->back()->with('success', 'Assigned Successfully');
    }

    public function addRandomNumbers()
    {
        $products = Product::all();
        return view('admin.add-random-numbers', ['products' => $products]);
    }
    public function addInstantNumbers($bundle_id)
    {
        $bundle = Bundle::where('id', $bundle_id)->first();
        $max = $bundle->limit - $bundle->assigned;
        $products = Product::all();
        return view('admin.add-instant-numbers', ['products' => $products, 'max' => $max, 'bundle' => $bundle]);
    }
    function random_strings($length_of_string)
    {

        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shuffle the $str_result and returns substring
        // of specified length
        return strtoupper(substr(
            str_shuffle($str_result),
            0,
            $length_of_string
        ));
    }
    function random_strings_condition($alphabets, $numbers, $remaining)
    {

        // String of all alphanumeric character
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $str_result_num = '0123456789987654321001234567899876543210';
        $str_result_total = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789987654321001234567899876543210abcdefghijklmnopqrstuvwxyz';

        // Shuffle the $str_result and returns substring
        // of specified length
        $alpha = strtoupper(substr(
            str_shuffle($str_result),
            0,
            $alphabets
        ));
        $num = substr(
            str_shuffle($str_result_num),
            0,
            $numbers
        );
        $mix = substr(
            str_shuffle($str_result_total),
            0,
            $remaining
        );
        return str_shuffle($alpha . $num . $mix);
    }
    function processGiftSave()
    {
        $random = $this->random_strings(8);
        $gift = new Gift();
        $gift->random_number = $random;
        if (!$gift->save()) {
            $this->processGiftSave();
        }
    }
    function processInstantSave($product, $type, $bundle)
    {
        $bundle_obj = Bundle::where('id', $bundle)->first();
        $random = $this->random_strings(8);
        $lottery = new Lottery();
        $lottery->random_number = $random;
        $lottery->product_id = $product;
        $lottery->bundle_id = $bundle;
        $lottery->type = $type;
        if (!$lottery->save()) {
            $this->processInstantSave($product, $type, $bundle);
        } else {
            Bundle::where('id', $bundle)->update(['assigned' => \DB::raw('assigned+1')]);
        }
    }
    function processLotterySave($product, $type, $alphabets, $numbers, $total_digits)
    {
        $remaining = $total_digits - ($alphabets + $numbers);
        $random = $this->random_strings_condition($alphabets, $numbers, $remaining);
        $found = Lottery::where('random_number', $random)->whereNull('phone_number')->where('product_id', $product)->where('type', $type)->first();
        if ($found) {
            return false;
            // $this->processLotterySave($product, $type, $alphabets, $numbers, $total_digits);
        }
        $lottery = new Lottery();
        $lottery->random_number = $random;
        $lottery->product_id = $product;
        $lottery->type = $type;
        if (!$lottery->save()) {
            return false;
            // $this->processLotterySave($product, $type, $alphabets, $numbers, $total_digits);
        }
        return true;
    }
    public function saveRandomNumbers(Request $request)
    {
        $request->validate(
            [
                'counter_lottery' => 'required|min:1',
                'product' => 'required',
                'alphabets' => 'required',
                'numbers' => 'required',
                'total_digits' => 'required|gte:' . ($request->input('alphabets') + $request->input('numbers')),
            ],
            [
                'total_digits.in' => 'Total digits must be equal to sum of alphabets and numbers',
                'counter_type.required' => 'Limit field is required',
                'counter_type.min' => 'Limit field should me 1 as minumum value',
            ]
        );
        set_time_limit(0);
        $sizeLimitLottery = (int)$request->counter_lottery;
        $type = $request->telecom == 1 ? 'telecom' : 'lottery';
        $saved_count = 0;
        if ($sizeLimitLottery > 0) {
            for ($i = 1; $i <= $sizeLimitLottery; $i++) {
                $saved_or_not = $this->processLotterySave($request->product, $type, $request->alphabets, $request->numbers, $request->total_digits);
                if ($saved_or_not) {
                    $saved_count++;
                }
            }
        }
        // return redirect()->back()->with(['success' => 'Successfully added' . $sizeLimitLottery . ' Lottery QR codes, <a href="' . url('/admin/lottery/listing') . '"> click here  </a>  to see the qr codes']);
        return redirect()->back()->with(['success' => 'Successfully added ' . $saved_count . ' QR codes And ' . $sizeLimitLottery - $saved_count . ' Failed, <a href="' . url('/admin/' . $type . '/listing') . '"> click here  </a>  to see the qr codes']);
    }
    public function saveInstantNumbers(Request $request)
    {
        set_time_limit(0);
        $sizeLimitGift = (int)$request->counter_gift;
        if ($sizeLimitGift > 0) {
            for ($i = 1; $i <= $sizeLimitGift; $i++) {
                $this->processInstantSave($request->product, 'gift', $request->bundle);
            }
        }
        return redirect()->back()->with(['success' => 'Successfully added' . $sizeLimitGift . ' Gifts QR codes, <a href="' . url('/admin/instant/listing') . '"> click here  </a>  to see the qr codes']);
    }
    public function makeMekanoWinner(Request $request)
    {
        Mekano::where('id', $request->mekano_id)->update([
            'win_status' => 1,
            'winning_date' => new \DateTime()
        ]);
    }

    public function makeLotteryWinner(Request $request)
    {
        $lottery = Lottery::where('random_number', $request->random_number)->first();
        if ($lottery) {
            $bundle_array = [];
            $package = Package::where('id', $request->package_id)->first();
            if ($package && count($package->bundles)) {
                foreach ($package->bundles as $bundle) {
                    $count_bundle = 0;
                    $count_bundle = $count_bundle + ($bundle->limit - $bundle->assigned);
                    if ($count_bundle > 0) {
                        for ($i = 1; $i <= $count_bundle; $i++) {
                            $bundle_array[] = $bundle->id;
                        }
                    }
                }
            } else {
                return response()->json(['success' => true, 'status' => 500, 'message' => 'package not found or package has no bundles']);
            }
            if (count($bundle_array)) {
                $bndl = Arr::random($bundle_array, 1);
                if ($bndl) {
                    Lottery::where('random_number', $request->random_number)->update([
                        'win_status' => 1,
                        'winning_date' => new \DateTime(),
                        'type' => 'gift',
                        'bundle_id' => $bndl[0]
                    ]);
                    Bundle::where('id', $bndl[0])->update(['assigned' => \DB::raw('assigned+1')]);
                    return response()->json(['success' => true, 'status' => 500, 'message' => 'winner made successfully']);
                }
            } else {
                return response()->json(['success' => true, 'status' => 500, 'message' => 'This package has no more bundle gifts']);
            }
        } else {
            return response()->json(['success' => true, 'status' => 500, 'message' => 'code not found']);
        }
    }
    public function makeWinnerAuto(Request $request)
    {

        $auto_winnersCount = $request->auto_winners;
        $package = Package::where('id', $request->package_id)->first();
        $gift_type = $request->gift_type;
        $algo_type = $request->algo_type;
        if ($algo_type == 'single') {
            $lotteries = Lottery::where('user_id', '!=', 0)->where('win_status', 0)->where('type', $gift_type)->inRandomOrder()->limit($auto_winnersCount)->groupby('user_id')->get();
        } else {
            $lotteries = Lottery::where('user_id', '!=', 0)->where('win_status', 0)->where('type', $gift_type)->inRandomOrder()->limit($auto_winnersCount)->get();
        }
        $bundles_arr = [];
        foreach ($package->bundles as $bundle) {
            $count_bundle = 0;
            $count_bundle = $count_bundle + ($bundle->limit - $bundle->assigned);
            if ($count_bundle > 0) {
                for ($i = 1; $i <= $count_bundle; $i++) {
                    $bundles_arr[] = $bundle->id;
                }
            }
        }
        foreach ($lotteries as $lottery) {
            $bndl = Arr::random($bundles_arr, 1);
            if ($bndl) {
                $lottery->win_status = 1;
                $lottery->winning_date = new \DateTime();
                $lottery->type = $gift_type;
                $lottery->bundle_id = $bndl[0];
                $lottery = $lottery->save();
                Bundle::where('id', $bndl[0])->update(['assigned' => \DB::raw('assigned+1')]);
            }
        }
        return response()->json(['success' => true, 'status' => 200, 'message' => 'successfully done']);
    }
    public function lotteryListing(Request $request)
    {
        $limit = $request->limit ?? 10;
        if (Auth::user()->hasPermission('view_gift_campaign')) {
            $lotteryListing = Lottery::where('type', 'lottery')->where('user_id', 0)->orderby('created_at', 'desc')->paginate($limit);
            return view('admin.lottery-campaign-listing', compact('lotteryListing', 'limit'));
        } else {
            return view('admin.access_denied');
        }
    }
    public function telecomListing(Request $request)
    {
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
        $products = Product::all();
        $limit = $request->limit ?? 10;
        if (Auth::user()->hasPermission('view_gift_campaign')) {
            $lotteryListing = Lottery::when($request->product, function ($sub) use ($request) {
                $sub->where('product_id', $request->product);
            })->when($request->from_date, function ($sub) use ($request) {
                $sub->where('created_at', '>=', $request->from_date);
            })->when($request->to_date, function ($sub) use ($request) {
                $sub->where('created_at', '<=', $request->to_date);
            })->when($request->status == '1', function ($sub) use ($request) {
                $sub->whereNull('phone_number');
            })->when($request->status == '0', function ($sub) use ($request) {
                $sub->whereNotNull('phone_number');
            })
                ->when($max > 0 && $min > 0, function ($mq) use ($min, $max) {
                    $mq->where('id', '<', $min)
                        ->orWhere('id', '>', $max);
                })
                ->where('type', 'telecom')->orderby('created_at', 'desc')->orderby('id', 'desc')->paginate($limit);
            return view('admin.telecom-campaign-listing', compact('lotteryListing', 'limit', 'products'));
        } else {
            return view('admin.access_denied');
        }
    }
    public function instantListing(Request $request)
    {
        $limit = $request->limit ?? 10;
        if (Auth::user()->hasPermission('view_gift_campaign')) {
            $lotteryListing = Lottery::where('type', 'gift')->where('user_id', 0)->orderby('created_at', 'desc')->paginate($limit);
            return view('admin.instant-campaign-listing', compact('lotteryListing', 'limit'));
        } else {
            return view('admin.access_denied');
        }
    }

    public function lottery()
    {
        for ($i = 1; $i <= 1000; $i++) {
            sleep(1);
            $random = substr(sha1(time()), 0, 7);
            Lottery::insert([
                'random_number' => strtoupper($random),

            ]);
        }
    }

    public function translatePageSave(Request $request)
    {
        $qname = $request->filename;
        //dd($request->all());
        Page::insert([
            'title' => $request->title,
            'parent_id' => $request->parent_id,
            'page_image' => $qname,
            'trans_status' => 1,
            'description' => $request->description,
            'trans_id' => $request->trans_id,
            'lang_name' => $request->lang_name,
            'content' => $request->content,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ]);

        $latestObj = Page::orderBy('id', 'desc')->first();

        Page::where('trans_id', $latestObj->trans_id)->update(['trans_status' => 1]);


        return redirect('/admin/page/')->with(['success' => 'Successfully updated record!']);
    }

    public function translatePageUpdate(Request $request)
    {

        $qname = $request->filename;

        Page::where('id', $request->id)->update([
            'title' => $request->title,
            'parent_id' => $request->parent_id,
            'page_image' => $qname,
            'trans_status' => 1,
            'description' => $request->description,
            'trans_id' => $request->trans_id,
            'lang_name' => $request->lang_name,
            'content' => $request->content,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ]);

        return redirect('/admin/page/')->with(['success' => 'Successfully updated record!']);
    }

    public function translatePageEdit($id)
    {
        $dataObj = Page::where('id', $id)->first();
        //dd($dataObj);
        return view('admin.edit-page-translation', ['dataObj' => $dataObj]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function create()
    {
        return view('admin.forms.page', $this->formVariables('page', null, $this->options()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store(Request $request)
    {
        return $this->createFlashRedirect(Page::class, $request);
    }

    /**
     * @param \App\Models\Page $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function show(Page $page)
    {
        return view('admin.show', ['object' => $page]);
    }

    /**
     * @param \App\Models\Page $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit(Page $page)
    {
        return view('admin.forms.page', $this->formVariables('page', $page, $this->options($page->id)));
    }

    /**
     * @param \App\Models\Page $page
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update(Page $page, Request $request)
    {
        return $this->saveFlashRedirect($page, $request);
    }

    /**
     * @param \App\Models\Page $page
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Page $page)
    {
        return $this->destroyFlashRedirect($page);
    }

    /**
     * @param null $id
     *
     * @return array
     */
    protected function options($id = null): array
    {
        return ['options' => Page::when($id !== null, function ($q) use ($id) {
            return $q->where('id', '!=', $id)->where('parent_id', null);
        })->pluck('title', 'id')];
    }

    public function sticksListing()
    {
        if (Auth::user()->hasPermission('view_stick')) {
            $sticks = Stick::orderby('updated_at', 'desc')->get();
            return view('admin.sticks-listing', ['sticks' => $sticks]);
        } else {
            return view('admin.access_denied');
            // return redirect()->back()->with('error',  __("admin.access_denied"));
        }
    }

    public function sticksEdit($id)
    {
        if (Auth::user()->hasPermission('update_stick')) {
            $stick = Stick::where('id', $id)->first();
            if (count($stick->mekanos))
                return redirect()->back()->with('error', 'Not allowed as this stick range taken by mekanos');
            else
                return view('admin.sticks-edit-form', ['stick' => $stick]);
        } else {
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    public function sticksUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required|unique_with:sticks,from',

        ]);
        $range = $request->from . '-' . $request->to;
        $stick = Stick::where('id', $request->id)->update(['from' => $request->from, 'to' => $request->to, 'range' => $range]);
        return redirect('/admin/sticks/listing')->with(['success' => 'Successfully Updated!']);
    }

    public function sticksDelete(Request $request)
    {
        if (Auth::user()->hasPermission('delete_stick')) {
            $stick = Stick::where('id', $request->id)->first();
            if (count($stick->mekanos))
                return redirect()->back()->with('error', 'Not allowed as this stick range taken by mekanos');
            else {
                Stick::where('id', $request->id)->delete();
                return redirect('/admin/sticks/listing')->with(['success' => 'Successfully Deleted!']);
            }
        } else {
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    public function sticksCreate()
    {
        if (Auth::user()->hasPermission('add_stick'))
            return view('admin.sticks-form');
        else {
            return view('admin.access_denied');
        }
    }

    public function sticksSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required|unique_with:sticks,from',

        ]);
        $range = $request->from . '-' . $request->to;
        $stick = new Stick();
        $stick->from = $request->from;
        $stick->to = $request->to;
        $stick->range = $range;
        $stick->save();
        return redirect('/admin/sticks/listing')->with(['success' => 'Successfully added!']);
    }

    public function uploadMekano()
    {
        $sticks = Stick::all();
        return view('admin.mekano-form', ['sticks' => $sticks]);
    }

    public function saveMekano(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'no_sticks' => 'required'
        ]);
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $qnames = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $image['filePath'] = $qnames;
            $file->move(public_path() . '/uploads/categories/', $qnames);
            $qname = $qnames;
        }
        Mekano::insert(['no_sticks' => $request->no_of_sticks, 'user_id' => auth()->user()->id, 'image' => $qname, 'win_status' => '1', 'seen' => 1, 'winning_date' => new \DateTime()]);
        return redirect('/admin/mekano/listing')->with(['success' => 'Successfully added!']);
    }

    public function exportQrCodes($type)
    {
        return Excel::download(new LotteryExport($type), 'QR-Codes.xlsx');
    }

    public function exportPdfQrcodes(Request $request, $type)
    {
        $request->validate(
            [
                'from' => 'required|numeric|min:1',
                'to' => 'required|numeric|min:1|gte:from',
            ],
            [
                'from.required' => 'Start field is required',
                'from.min' => 'Start field must have at least 1 as value',
                'from.numeric' => 'Start field only can accept numeric value',
                'to.numeric' => 'End field only can accept numeric value',
                'to.min' => 'End field must have at least 1 as value',
                'to.required' => 'End field is required',
                'to.gte' => 'End number should be greater than or equal to Start number',
            ]
        );
        $skip = $request->from - 1;
        $take = ($request->to - $request->from) + 1;
        $numbers = Lottery::where('type', $type)->skip($skip)->take($take)->orderby('created_at', 'desc')->orderby('id', 'desc')->get();
        $data['lotteryListing'] = $numbers;
        $data['type'] = ucfirst($type);
        $pdf = PDF::loadView('admin.export-qr-codes-pdf', $data);
        return $pdf->download('QrCodes.pdf');
    }

    public function printTextTelecomCodes(Request $request)
    {
        $request->validate(
            [
                'no_of_codes' => 'required|numeric|min:1',
            ],
            [
                'no_of_codes.required' => 'No. of Codes field is required',
            ]
        );
        $take = $request->no_of_codes;
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
        $numbers = Lottery::where('type', 'telecom')
            ->when($max > 0 && $min > 0, function ($mq) use ($min, $max) {
                $mq->where('id', '<', $min)
                    ->orWhere('id', '>', $max);
            })->orderby('created_at', 'desc')->orderby('id', 'desc')->take($take)->pluck('id');
        if (count($numbers)) {
            $end = $numbers[0];
            $start = $numbers[count($numbers) - 1];
            $files = ceil($take / 10000);
            PrintBatch::create([
                'start_id' => $start,
                'end_id' => $end,
                'total_files' => $files
            ]);
            return redirect()->back()->with('success', 'Print Batch is added to Schedule, Files will be created and saved soon');
            // return redirect()->route('telecom.listings')->with('success', 'Print Batch is added to Schedule, Files will be created and saved soon');
        } else {
            return redirect()->back()->with('error', 'Not found Codes to print');
        }
    }

    public function assignTimes(Request $request)
    {
        if (!$request->id) {
            return View::make('admin.assignTimesAjax', ['success' => false, 'error' => 'something went wrong, please try again', 'winner_setting' => []]);
        }
        $winner_setting = WinnerSetting::whereId($request->id)->first();
        return View::make('admin.assignTimesAjax', ['success' => true, 'error' => '', 'winner_setting' => $winner_setting]);
    }

    public function addTime(Request $request)
    {
        $errors = [];
        $time = WinnerSettingDateTime::where('winner_setting_id', $request->id)
            ->whereTime('start_time', '<=', $request->end_time . ":00")
            ->whereTime('end_time', '>=', $request->start_time . ":00")->first();
        if (!$time) {
            $validator = Validator::make($request->all(), [
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after_or_equal:start_time',
                'no_winners' => 'required|numeric|min:1',
                'winner_out_of' => 'required|gte:no_winners|numeric|min:1',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->getMessages();
                $winner_setting = WinnerSetting::whereId($request->id)->first();
                return View::make('admin.assignTimesAjax', ['success' => true, 'errors' => $errors, 'winner_setting' => $winner_setting]);
            }
            $add = WinnerSettingDateTime::create([
                'winner_setting_id' => $request->id,
                'no_winners' => $request->no_winners,
                'winner_out_of' => $request->winner_out_of,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time
            ]);
            if ($add) {
                $array_ = [];
                for ($i = 0; $i < $add->no_winners; $i++) {
                    $array_[$i] = 'w';
                }
                if ($add->winner_out_of - $add->no_winners > 0) {
                    for ($i = $add->no_winners; $i < $add->winner_out_of; $i++) {
                        $array_[$i] = 'l';
                    }
                }
                shuffle($array_);
                $add->remaining = $add->winner_out_of;
                $add->json_array = json_encode($array_);
                $add->save();
            }
        } else {
            $error[] = 'Time stamp is already added';
            $errors['server_error'] = $error;
        }
        $winner_setting = WinnerSetting::whereId($request->id)->first();
        return View::make('admin.assignTimesAjax', ['success' => true, 'errors' => $errors, 'winner_setting' => $winner_setting]);
    }

    public function deleteTime(Request $request)
    {
        $time = WinnerSettingDateTime::where('id', $request->id)->first();
        $setting_id = $time->setting->id;
        $time->delete();
        $winner_setting = WinnerSetting::whereId($setting_id)->first();
        return View::make('admin.assignTimesAjax', ['success' => true, 'error' => '', 'winner_setting' => $winner_setting]);
    }

    public function printTextBatches(Request $request)
    {
        $limit = $request->limit ? $request->limit : 20;
        $batches = PrintBatch::orderby('created_at', 'desc')->paginate($limit);
        return view('admin.batches', compact('batches', 'limit'));
    }

    public function printTextBatchFiles(Request $request)
    {
        $limit = $request->limit ? $request->limit : 20;
        $batch_files = PrintBatchFile::where('print_batch_id', $request->batch_id)->orderby('created_at', 'asc')->orderby('id', 'asc')->paginate($limit);
        return view('admin.batch_files', compact('batch_files', 'limit'));
    }

    public function printTextBatchFileDownload(Request $request)
    {
        $file = PrintBatchFile::whereId($request->file_id)->first();
        if ($file) {
            return response()->download(public_path('uploads/textfiles/' . $file->batch->id . '/' . $file->file_name));
        } else {
            return redirect()->back()->with('error', "File Not Found");
        }
    }
}
