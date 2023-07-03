<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
class PackageController extends AdminController
{
    /**
     * @return mixed
     */
    public function index()
    {   
      if(Auth::user()->hasPermission('view_package'))
      {
          $packages=Package::all();
          return view('admin.gift-package-listing',['packages'=>$packages]);
      }
      else{
        return view('admin.access_denied');
      }
    }
   public function packages()
   {   
    if(Auth::user()->hasPermission('view_package'))
    {
        $packages=Package::all();
        return view('admin.gift-package-listing',['packages'=>$packages]);
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
      if(Auth::user()->hasPermission('add_package'))
        return view('admin.gift-package-create');
        else
        return view('admin.access_denied');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
        ], [
            'end_date.after_or_equal' => 'The end date must be greater than or equal to start date.'
        ]);        
        $end_date = $request->end_date;
        $start_date = $request->start_date;
            try{
         Package::create([
            'name' =>$request->name,
            'start_date' =>$request->start_date,
            'end_date' =>$request->end_date,
         ]);

         }
         catch(\Exception $e){
           return $e->getMessage();
         }

         return redirect('/admin/packages')->with(['success'=>'Successfully added record!']); 
       // return $this->createFlashRedirect(Category::class, $request);
    }

    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit($id)
    {       
      if(Auth::user()->hasPermission('update_package'))
      {
        $package = Package::where('id', $id)->first();
        return view('admin.edit-gift-package', ['package'=>$package]);
      }
      else{
        return redirect()->back()->with('error', __('admin.access_denied'));
      }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
        ], [
            'end_date.after_or_equal' => 'The end date must be greater than or equal to start date.'
        ]); 
        $end_date = $request->end_date;
        $start_date = $request->start_date;
         Package::where('id',$request->id)->update([
            'name'=>$request->name,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
          ]);
        return redirect('/admin/packages/')->with(['success'=>'Successfully updated record!']);
    }

    public function show(Package $package)
    {
        //dd($category);
        // $dataTable=new CategoryDataTable; 
        return view('admin.show', ['object' => $package]);
    }

    public function delete($id)
    {
        if(Auth::user()->hasPermission('delete_package'))
        {
        Package::where('id', $id)->delete();
        return redirect('/admin/packages/')->with(['success'=>'Successfully deleted record!']);
        }
        else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }
}
