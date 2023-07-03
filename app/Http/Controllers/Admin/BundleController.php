<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Models\Package;
use App\Models\Bundle;
use App\Models\Lottery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Image;
class BundleController extends AdminController
{
    /**
     * @return mixed
     */
    public function index()
    {   
      if(Auth::user()->hasPermission('view_bundle'))
      {
          $bundles=Bundle::with('lotteries')->orderby('created_at', 'desc')->get();
          return view('admin.gift-bundle-listing',['bundles'=>$bundles]);
      }
      else{
        return view('admin.access_denied');
      }
    }
   public function bundles()
   {   
    if(Auth::user()->hasPermission('view_bundle'))
    {
        $bundles=Bundle::with('package')->orderby('created_at', 'desc')->get();
        return view('admin.gift-bundle-listing',['bundles'=>$bundles]);
    }
    else{
      return view('admin.access_denied');
    }
   }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function create()
    {
      if(Auth::user()->hasPermission('add_bundle'))
      {
        $packages = Package::where('end_date', '>=', Carbon::now())->orderby('created_at', 'desc')->get();
        return view('admin.gift-bundle-create', ['packages' => $packages]);
      }
      else
      {
        return view('admin.access_denied');
      }
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store(Request $request)
    {
            try{
         Bundle::create([
            'name' =>$request->name,
            'package_id' =>$request->package_id,
            'limit' =>$request->limit,
         ]);

         }
         catch(\Exception $e){
           return $e->getMessage();
         }

         return redirect('/admin/bundles')->with(['success'=>'Successfully added record!']); 
       // return $this->createFlashRedirect(Category::class, $request);
    }

    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit($id)
    {       
      if(Auth::user()->hasPermission('update_bundle'))
      {
        $packages = Package::where('end_date', '>=', Carbon::now())->orderby('created_at', 'desc')->get();
        $bundle = Bundle::where('id', $id)->first();
        return view('admin.edit-gift-bundle', ['bundle'=>$bundle, 'packages' => $packages]);
      }
      else{
        return redirect()->back()->with('error', __('admin.access_denied'));
      }
    }

    public function update(Request $request)
    {
         Bundle::where('id',$request->id)->update([
            'name'=>$request->name,
            'package_id'=>$request->package_id,
            'limit'=>$request->limit,
          ]);
        return redirect('/admin/bundles/')->with(['success'=>'Successfully updated record!']);
    }

    public function delete($id)
    {
      if(Auth::user()->hasPermission('delete_bundle'))
      {
        Bundle::where('id',$id)->delete();
        return redirect('/admin/bundles/')->with(['success'=>'Successfully deleted record!']);
      }
      else{
        return redirect()->back()->with('error', __('admin.access_denied'));
      }

   }

   public function winners($id)
   {
       if(Auth::user()->hasPermission('view_gift_campaign'))
       {
       $bundle = Bundle::where('id', $id)->first();
       $lotteries = Lottery::where('bundle_id', $id)->orderby('created_at', 'desc')->get();
       return view('admin.winners', ['winners' => $lotteries, 'bundle' => $bundle]);
       }
       else{
           return redirect()->back()->with('error', __('admin.access_denied'));
       }
   }

   public function allWinners()
   {
    $limit = $request->limit ?? 10;
       if(Auth::user()->hasPermission('view_gift_campaign'))
       {
       $lotteries = Lottery::where('win_status', 1)->orderby('created_at', 'desc')->paginate($limit);
       return view('admin.all-winners', ['winners' => $lotteries]);
       }
       else{
           return redirect()->back()->with('error', __('admin.access_denied'));
       }
   }
   public function LotteryWinners()
   {
    $limit = $request->limit ?? 10;
       if(Auth::user()->hasPermission('view_gift_campaign'))
       {
       $lotteries = Lottery::where('win_status', 1)->where('type', 'lottery')->orderby('created_at', 'desc')->paginate($limit);
       return view('admin.all-winners', ['winners' => $lotteries, 'type' => 'lottery']);
       }
       else{
           return redirect()->back()->with('error', __('admin.access_denied'));
       }
   }
   public function giftWinners()
   {
    $limit = $request->limit ?? 10;
       if(Auth::user()->hasPermission('view_gift_campaign'))
       {
       $lotteries = Lottery::where('win_status', 1)->where('type', 'gift')->where('user_id', '!=', 0)->orderby('created_at', 'desc')->paginate($limit);
       return view('admin.all-winners', ['winners' => $lotteries, 'type' => 'gift']);
       }
       else{
           return redirect()->back()->with('error', __('admin.access_denied'));
       }
   }
}
