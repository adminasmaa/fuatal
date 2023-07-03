<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Http\Controllers\Admin\DataTables\CategoryDataTable;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
class CategoryController extends AdminController
{
    /**
     * @var array
     */
    protected $validation = ['title' => 'required|string|max:200'];

    /**
     * @param \App\Http\Controllers\Admin\DataTables\CategoryDataTable $dataTable
     *
     * @return mixed
     */
    public function index()
    {   
        if(Auth::user()->hasPermission('add_category'))
        {
        $catObj1=Category::where('parent_id',0)->where('lang_name', 'English')->get();
        $catView=view('admin.dynamic-cat-all');
        //echo($catView);
        
        $catWhole=Category::where('lang_name', 'English')->get();
        return view('admin.category',['catView'=>$catView,'catWhole'=>$catWhole,'catObj1'=>$catObj1]);
        //return $dataTable->render('admin.table', ['link' => route('admin.category.create')]);
        }
        else{
            return view('admin.access_denied');
        }
    }
   public function categories()
   {   
        //dd('yes');
         if(Auth::user()->hasPermission('view_category'))
         {
       //$catObj1=Category::orderBy('trans_id','Asc')->get();
        $view = view('admin.dynamic-cat');

        $catWhole=Category::where('lang_name', 'English')->get();
        return view('admin.category-listing',['view'=>$view,'catWhole'=>$catWhole]);
        //return $dataTable->render('admin.table', ['link' => route('admin.category.create')]);
         }
         else{
             return view('admin.access_denied');
         }
    }
    public function translateCategory($id)
    {
        if(Auth::user()->hasPermission('add_category'))
        {

        $dataObj=Category::where('id',$id)->first();

        $catObj=Category::all();   

        
        return view('admin.category-translation',['catObj'=>$catObj,'dataObj'=>$dataObj]);
        //return $dataTable->render('admin.table', ['link' => route('admin.category.create')]);
        }
        else{
            return redirect()->back()->with('error', __("admin.access_denied"));
        }
    }

    public function edittranslateCategory($id)
    {   
        if(Auth::user()->hasPermission('update_category'))
        {

        $dataObj=Category::where('id',$id)->first();

        $catObj=Category::all();  
        

        return view('admin.edit-category-translation',['catObj'=>$catObj,'dataObj'=>$dataObj]);
        //return $dataTable->render('admin.table', ['link' => route('admin.category.create')]);
        }
        else{
            return redirect()->back()->with('error', __("admin.access_denied"));
        }
    }
    public function translateCategorySave(Request $request)
    {   
       
         $qname=$request->filename;
         try{
         Category::insert([
            'title' =>$request->title,
            'parent_id'=>$request->parent_id,
            'lang_name'=>$request->lang_name,
            'trans_id'=>$request->trans_id,
            'slug'=>$request->title,
            'color_code'=>$request->color_code,
            'cat_image'=>$qname,
            'trans_status'=>1,
            //'description' => $request->description,
            'created_at'=>date('d-m-Y H:i:s'),
            'updated_at'=>date('d-m-Y H:i:s'),
         ]);

            Category::where('trans_id',$request->trans_id)->update(['trans_status'=>1]);

         }
         catch(\Exception $e){
            dd($e->getMessage());
         }
       

        return redirect('/admin/listing/categories/')->with(['success'=>'Successfully updated record!']);
    }


    public function translateCategoryUpdate(Request $request)
    {   
       
         $qname=$request->filename;
         Category::where('id',$request->id)->update([
            'title' =>$request->title,
            'parent_id'=>$request->parent_id,
            'lang_name'=>$request->lang_name,
            'trans_id'=>$request->trans_id,
            'slug'=>$request->title,
            'cat_image'=>$qname,
            'trans_status'=>1,
            //'description' => $request->description,
            'created_at'=>date('d-m-Y H:i:s'),
            'updated_at'=>date('d-m-Y H:i:s'),
         ]);

        

         return redirect('/admin/listing/categories/')->with(['success'=>'Successfully updated record!']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function create()
    {

        return view('admin.forms.category', $this->formVariables('category', null));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $qname = "";
        if($request->hasfile('cat_image_before'))
        {
            //  crop image start
          $file=$request->file('cat_image_before');
          $qnames = $file->getClientOriginalName();
          $image_parts = explode(";base64,", $request->cat_image);
          if(isset($image_parts[0]) && $image_parts[0] != "")
          {
              $image_type_aux = explode("image/", $image_parts[0]);
              $image_type = $image_type_aux[1];
              $image_base64 = base64_decode($image_parts[1]);
              $imageName = $qnames;
              $imageFullPath = public_path().'/uploads/categories/'.$imageName;
              file_put_contents($imageFullPath, $image_base64);
          }
          else{
            $img = Image::make($file->path());
            $img->resize(360, 360, function ($constraint) {
            })->save(public_path().'/uploads/categories/'.$qnames);
          }
        // crop image end
            $qname= $qnames;  
       }
            try{

         Category::insert([
            'title' =>$request->title,
            'title_ar' =>$request->title_ar,
            'parent_id'=>$request->parent_id,
            'slug'=>strtolower($request->title),
            'cat_image'=>$qname,
            'color_code'=>$request->color_code,
            'trans_status'=>0,
            'lang_name'=>'English',
            //'description' => $description,
         ]);

         $latestObj=Category::orderBy('id', 'desc')->first();
         
         Category::where('id',$latestObj->id)->update(['trans_id'=>$latestObj->id]);
         }
         catch(\Exception $e){
           return $e->getMessage();
         }

         return redirect('/admin/listing/categories/')->with(['success'=>'Successfully added record!']); 
       // return $this->createFlashRedirect(Category::class, $request);
    }

    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function show(Category $category)
    {
        //dd($category);
        // $dataTable=new CategoryDataTable; 
        return view('admin.show', ['object' => $category]);
    }

    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit(Category $dataObj)
    {       
        if(Auth::user()->hasPermission('update_category'))
        {
        
        $catObj=Category::where('lang_name', 'English')->get(); 
        $id=$dataObj->parent_id;
        
        $view=view('admin.dynamic-cat-all-edit',['id'=>$id]);
        
        return view('admin.edit-category', ['view'=>$view,'dataObj'=>$dataObj,'catObj'=>$catObj]);
        }
        else{
            return redirect()->back()->with('error', __("admin.access_denied"));
        }
    }

    /**
     * @param \App\Models\Category $category
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update(Request $request)
    {
        //dd($request->all());
        
        //return $this->saveFlashRedirect($category, $request);
    }

    public function updateCategory(Request $request)
    {
       if($request->hasfile('cat_image_before'))
          {
            //   dd($request);
              //  crop image start
            $file=$request->file('cat_image_before');
            $qnames = $file->getClientOriginalName();
            $image_parts = explode(";base64,", $request->cat_image);
            if(isset($image_parts[0]) && $image_parts[0] != "")
            {
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
        
                $imageName = $qnames;
        
                $imageFullPath = public_path().'/uploads/categories/'.$imageName;
        
                file_put_contents($imageFullPath, $image_base64);
            }
            else{
                $image['filePath'] = $qnames;
                $img = Image::make($file->path());
                $img->resize(360, 360, function ($constraint) {
                    //   $constraint->aspectRatio();
                })->save(public_path().'/uploads/categories/'.$qnames);
            }
          // crop image end

            
              $qname= $qnames;  
         } else{

            $qname=$request->filename;
         }                                  
      

         Category::where('id',$request->id)->update([
            'title' =>$request->title,
            'title_ar' =>$request->title_ar,
            'parent_id'=>$request->parent_id,
            'cat_image'=>$qname,
            'slug'=>strtolower($request->title),
            //'description' => $request->description,
            'trans_id'=>$request->trans_id,
            'color_code'=>$request->color_code,
            'lang_name'=>$request->lang_name,
          ]);

        //   Category::where('trans_id',$request->id)->where('lang_name', 'Arabic')->update(['cat_image'=>$qname, 'color_code' => $request->color_code, 'parent_id' => $request->parent_id]);

        

        return redirect('/admin/listing/categories/')->with(['success'=>'Successfully updated record!']);
    }

    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        

        //return $this->destroyFlashRedirect($category);
    }

    public function deleteRecord(Request $request)
    {
        if(Auth::user()->hasPermission('delete_category'))
        {
        $id=$request->id;

        $obj=Category::where('id',$id)->first();
       if($obj->lang_name=='Arabic'){
        Category::where('trans_id',$obj->trans_id)->update(['trans_status'=>0]);
        Category::where('id',$id)->delete();
        



       }
       else{

       Category::where('trans_id',$id)->delete();

       }
    }
    else{
        return view('admin.access_denied');
    }

   }
}
