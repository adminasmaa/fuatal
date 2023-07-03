<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Http\Controllers\Admin\DataTables\CategoryDataTable;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
class SliderController extends AdminController
{
    /**
     * @var array
     */
    protected $validation = ['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'];

    /**
     * @param \App\Http\Controllers\Admin\DataTables\CategoryDataTable $dataTable
     *
     * @return mixed
     */
    public function index()
    {   
      if(Auth::user()->hasPermission('add_slider'))
      {
        $slider_count = Slider::count();
        if($slider_count >= 5)
        {
          return redirect('/admin/listing/sliders/')->with(['error'=>'Sliders Limit reached to 5. Please delete records to add new one.']);
        }
          $sliders=Slider::all();
          return view('admin.slider',['sliders'=>$sliders]);
      }
      else{
        return view('admin.access_denied');
      }
    }
   public function sliders()
   {   
    if(Auth::user()->hasPermission('view_slider'))
    {
        $sliders=Slider::all();
        return view('admin.slider-listing',['sliders'=>$sliders]);
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
      if(Auth::user()->hasPermission('add_slider'))
        return view('admin.forms.slider', $this->formVariables('slider', null));
        else
        return view('access-denied');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $qname = "";
        if($request->hasfile('image_before'))
        {
            //  crop image start
          $file=$request->file('image_before');
          $qnames = time().'_product_'.uniqid().$file->getClientOriginalName();
          $image_parts = explode(";base64,", $request->image);
          if(isset($image_parts[0]) && $image_parts[0] != "")
          {
              $image_type_aux = explode("image/", $image_parts[0]);
              $image_type = $image_type_aux[1];
              $image_base64 = base64_decode($image_parts[1]);
              $imageName = $qnames;
              $imageFullPath = public_path().'/uploads/sliders/'.$imageName;
              file_put_contents($imageFullPath, $image_base64);
          }
          else{
            $img = Image::make($file->path());
            $img->resize(626, 367, function ($constraint) {
              $constraint->aspectRatio();
            })->resizeCanvas(626, 367)->save(public_path().'/uploads/sliders/'.$qnames);
          }
          $qname= $qnames; 
        }
            try{

         Slider::create([
            'image' =>$qname,
         ]);

         }
         catch(\Exception $e){
           return $e->getMessage();
         }

         return redirect('/admin/listing/sliders/')->with(['success'=>'Successfully added record!']); 
       // return $this->createFlashRedirect(Category::class, $request);
    }

    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function editSlider($id)
    {       
      if(Auth::user()->hasPermission('update_slider'))
      {
        $slider = Slider::where('id', $id)->first();
        return view('admin.edit-slider', ['dataObj'=>$slider]);
      }
      else{
        return redirect()->back()->with('error', __('admin.access_denied'));
      }
    }

    public function updateSlider(Request $request)
    {
      if($request->hasfile('image_before'))
        {
            //  crop image start
          $file=$request->file('image_before');
          $qnames = time().'_product_'.uniqid().$file->getClientOriginalName();
          $image_parts = explode(";base64,", $request->image);
          if(isset($image_parts[0]) && $image_parts[0] != "")
          {
              $image_type_aux = explode("image/", $image_parts[0]);
              $image_type = $image_type_aux[1];
              $image_base64 = base64_decode($image_parts[1]);
              $imageName = $qnames;
              $imageFullPath = public_path().'/uploads/sliders/'.$imageName;
              file_put_contents($imageFullPath, $image_base64);
          }
          else{
            $img = Image::make($file->path());
            $img->resize(626, 367, function ($constraint) {
              $constraint->aspectRatio();
            })->resizeCanvas(626, 367)->save(public_path().'/uploads/sliders/'.$qnames);
          }
          $qname= $qnames; 
        }
        else{
          $qname=$request->filename;
        }                                 
         Slider::where('id',$request->id)->update([
            'image'=>$qname,
          ]);
        return redirect('/admin/listing/sliders/')->with(['success'=>'Successfully updated record!']);
    }

    public function deleteRecord($id)
    {
      if(Auth::user()->hasPermission('delete_slider'))
      {
        Slider::where('id',$id)->delete();
      }
      else{
        return redirect()->back()->with('error', __('admin.access_denied'));
      }

   }
}
