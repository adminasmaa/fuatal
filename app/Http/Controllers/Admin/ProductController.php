<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Http\Controllers\Admin\DataTables\CategoryDataTable;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;
use Image;
class ProductController extends AdminController
{
    /**
     * @var array
     */
    protected $validation = ['title' => 'required|string|max:200', 'description' => 'required|string|max:160', 'color_code' => 'required'];

    /**
     * @param \App\Http\Controllers\Admin\DataTables\CategoryDataTable $dataTable
     *
     * @return mixed
     */
    public function index()
    {   
        if(Auth::user()->hasPermission('add_product'))
        {
        $catObj=Category::where('lang_name', 'English')->get();

        $subObj=Product::select('products.*','categories.title as cat_title')
        ->where('products.lang_name', 'English')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->get();

        $catView=view('admin.dynamic-cat-all');

        return view('admin.product',['catView'=>$catView,'catObj'=>$catObj,'subObj'=>$subObj]);
        //return $dataTable->render('admin.table', ['link' => route('admin.category.create')]);
        }
        else{
            return view('admin.access_denied');
        }
    }

    public function products()
    {   
        if(Auth::user()->hasPermission('view_product'))
        {
        $catObj=Category::where('lang_name', 'English')->get();

        $subObj=Product::select('products.*','categories.title as cat_title')
        ->where('products.lang_name', 'English')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->orderBy('products.trans_id','DESC')
        ->orderBy('products.lang_name', 'ASC')
        ->get();
        //dd($subObj);
        return view('admin.product-listing',['catObj'=>$catObj,'subObj'=>$subObj]);
        //return $dataTable->render('admin.table', ['link' => route('admin.category.create')]);
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
        //dd($request->all());
        $validator = $request->validate(
        [
            'title' => 'required|string|max:200', 
            'title_ar' => 'required|string|max:200', 
            // 'description' => 'required|string|max:160', 
            'color_code' => 'required',
            'sku' => 'nullable|sometimes|unique:products,sku',
        ]);

        if(isset($request->image_data_url) && $request->image_data_url != "")
        {
            $imageDataURL = $request->image_data_url;
            $ImageDataURLArray = explode("img_url",$imageDataURL, -1);
            $images = array();
            foreach($ImageDataURLArray as $key => $image){
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $qnames = time().'_product_'.uniqid().'.png';
                $img = Image::make($image);
                  $img->resize(360, 360, function ($constraint) {
                    //   $constraint->aspectRatio();
                  })->save(public_path().'/uploads/categories/'.$qnames);
                
                // $imageFullPath = public_path().'/uploads/categories/'.$qnames;
                // file_put_contents($imageFullPath, base64_decode($image));
                // $path = \File::put(storage_path('app/public/post'). '/' . $qnames, base64_decode($image));
                // $images[$key] = $qnames;
                $qname[]= $qnames;
            }
            $qname =implode(",",$qname);
        }
        else if($request->hasfile('image_before'))
         {
              foreach($request->file('image_before') as $file)
              {
                  $qnames = $file->getClientOriginalName();
                  $image['filePath'] = $qnames;
                  $img = Image::make($file->path());
                  $img->resize(360, 360, function ($constraint) {
                    //   $constraint->aspectRatio();
                  })->save(public_path().'/uploads/categories/'.$qnames);
                  $qname[]= $qnames;  
                 
              }

             if(sizeof($qname)>5){

                session(['title'=>$request->title]);

             return redirect('/admin/product')->with(['error'=>'Maximum 5 images are allowed']);
             
             }

             $qname =implode(",",$qname);
        }

        else{
            $qname=null;
        }
        

          
         Product::insert([
            'title' =>$request->title,
            'title_ar' =>$request->title_ar,
            'product_size'=>$request->product_size,
            'sku'=>$request->sku,
            'nutritional_info'=>$request->nutritional_info,
            'nutritional_info_ar'=>$request->nutritional_info_ar,
            'category_id'=>$request->parent_id,
            'parent_id'=>$request->parent_id,
            'image'=>$qname,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'lang_name'=>'English',
            'trans_status'=>0,
            'offer'=>$request->offer,
            'color_code'=>$request->color_code,
            'video' => $request->video,
            'price'=>$request->price
         ]);

         $latestObj=Product::orderBy('id', 'desc')->first();
         Product::where('id',$latestObj->id)->update(['trans_id'=>$latestObj->id]);


        

        return redirect('/admin/listing/products')->with(['success'=>'Successfully updated record!']);
    
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
    public function edit($id)
    {       
        if(Auth::user()->hasPermission('update_product'))
        {
        $dataObj=Product::where('id',$id)->first();
        $catObj=Category::where('lang_name', 'English')->get(); 
        $id=$dataObj->category_id;
        //dd($id);
        $view=view('admin.dynamic-cat-all-edit-product',['id'=>$id]);

        return view('admin.edit-product', ['view'=>$view,'dataObj'=>$dataObj,'catObj'=>$catObj]);
        }
        else{
            return redirect()->back()->with('error', __("admin.access_denied"));
        }
    }

    public function translateProduct($id)
    {
        if(Auth::user()->hasPermission('add_product'))
        {
        $dataObj=Product::where('id',$id)->first();
        $catObj=Category::all();    
        return view('admin.product-translation', ['dataObj'=>$dataObj,'catObj'=>$catObj]);
        }
        else{
            return redirect()->back()->with('error', __("admin.access_denied"));
        }
    }

    public function translateProductSave(Request $request)
    {
        $qname=$request->filename;
        $prod_eng = Product::where('trans_id', $request->trans_id)->where('lang_name', 'English')->first();
        //dd($request->nutritional_info);
        Product::insert([
            'title' =>$request->title,
            'category_id'=>$request->parent_id,
            'product_size'=>$request->product_size,
            'sku'=>$request->sku,
            'nutritional_info'=>$request->nutritional_info,
            'parent_id'=>$request->parent_id,
            'image'=>$qname,
            'trans_status'=>1,
            'description' => $request->description,
            'trans_id'=>$request->trans_id,
            'lang_name'=>$request->lang_name,
            'offer' => $prod_eng->offer,
            'color_code' => $prod_eng->color_code,
            'video' => $prod_eng->video,
            'price'=>$request->price
         ]);

         $latestObj=Product::orderBy('id','desc')->first();
        // dd($latestObj->id);
         Product::where('trans_id',$latestObj->trans_id)->update(['trans_status'=>1]); 
        

    return redirect('/admin/listing/products')->with(['success'=>'Successfully updated record!']);
    
    }

    public function edittranslateProduct($id)
    {
        if(Auth::user()->hasPermission('update_product'))
        {
        $dataObj=Product::where('id',$id)->first();
        $catObj=Category::all();    
        return view('admin.edit-product-translation', ['dataObj'=>$dataObj,'catObj'=>$catObj]);
        }
        else{
            return redirect()->back()->with('error', __("admin.access_denied"));
        }

    }

    public function translateProductUpdate(Request $request)
    {
        $qname=$request->filename;

        Product::where('id',$request->id)->update([
            'title' =>$request->title,
            'category_id'=>$request->parent_id,
            'product_size'=>$request->product_size,
            'sku'=>$request->sku,
            'nutritional_info'=>$request->nutritional_info,
            'parent_id'=>$request->parent_id,
            'image'=>$qname,
            'description' => $request->description,
            'trans_id'=>$request->trans_id,
            'lang_name'=>$request->lang_name,
         ]);

    return redirect('/admin/listing/products')->with(['success'=>'Successfully updated record!']);
   
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

    public function updateProduct(Product $product, Request $request)
    {
        $validator = $request->validate(
            [
                'title' => 'required|string|max:200', 
                'title_ar' => 'required|string|max:200', 
                // 'description' => 'required|string|max:160', 
                'color_code' => 'required',
                'sku' => 'nullable|sometimes|unique:products,sku,'.$request->id,
            ]);
            $qname = [];
        if(isset($request->image_data_url) && $request->image_data_url != "")
        {
            $imageDataURL = $request->image_data_url;
            $ImageDataURLArray = explode("img_url",$imageDataURL, -1);
            $images = array();
            foreach($ImageDataURLArray as $key => $image){
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $qnames = time().'_product_'.uniqid().'.png';
                $img = Image::make($image);
                  $img->resize(360, 360, function ($constraint) {
                    //   $constraint->aspectRatio();
                  })->save(public_path().'/uploads/categories/'.$qnames);
                
                // $imageFullPath = public_path().'/uploads/categories/'.$qnames;
                // file_put_contents($imageFullPath, base64_decode($image));
                // $path = \File::put(storage_path('app/public/post'). '/' . $qnames, base64_decode($image));
                // $images[$key] = $qnames;
                $qname[]= $qnames;
            }
            // $qname =implode(",",$qname);
        }
        else if($request->hasfile('image_before'))
         {
              foreach($request->file('image_before') as $file)
              {
                  $qnames = $file->getClientOriginalName();
                  $image['filePath'] = $qnames;
                  $img = Image::make($file->path());
                  $img->resize(360, 360, function ($constraint) {
                    //   $constraint->aspectRatio();
                  })->save(public_path().'/uploads/categories/'.$qnames);
                  $qname[]= $qnames;  
                 
              }

             if(sizeof($qname)>5){

                session(['title'=>$request->title]);

             return redirect('/admin/product')->with(['error'=>'Maximum 5 images are allowed']);
             
             }

            //  $qname =implode(",",$qname);
        }
        $product = Product::where('id', $request->id)->first();
        $prev_images = explode(',', $product->image);
        if(count($prev_images))
        {
            $qname = array_merge($qname, $prev_images);
        }
        $qname =implode(",",$qname);

         Product::where('id',$request->id)->update([
            'title' =>$request->title,
            'title_ar' =>$request->title_ar,
            'category_id'=>$request->parent_id,
            'product_size'=>$request->product_size,
            'sku'=>$request->sku,
            'nutritional_info'=>$request->nutritional_info,
            'nutritional_info_ar'=>$request->nutritional_info_ar,
            'parent_id'=>$request->parent_id,
            'image'=>$qname,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'trans_id'=>$request->trans_id,
            'lang_name'=>$request->lang_name,
            'offer'=>$request->offer,
            'color_code'=>$request->color_code,
            'video'=>$request->video,
            'price'=>$request->price
         ]);
        //  Product::where('trans_id', $request->id)->where('lang_name', 'Arabic')->update(['offer' => $request->offer, 'color_code' => $request->color_code, 'price' => $request->price, 'product_size' => $request->product_size, 'image' => $qname]);

        

        return redirect('/admin/listing/products')->with(['success'=>'Successfully updated record!']);
    }

    public function viewProduct($id)
    {
        if(Auth::user()->hasPermission('view_product'))
        {
        $product = Product::where('id', $id)->first();
        $images = explode(',',$product->image);
        return view('admin.view-product', ['product'=>$product, 'images' => $images]);
        }
        else{
            return view('admin.access_denied');
        }
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
        if(Auth::user()->hasPermission('delete_product'))
        {
        $id=$request->id;

        $obj=Product::where('id',$id)->first();
       if($obj->lang_name=='Arabic'){

        Product::where('trans_id',$obj->trans_id)->update(['trans_status'=>0]);
        Product::where('id',$id)->delete();
        



       }
       else{

       Product::where('trans_id',$id)->delete();

       }
    }
    else{
        return view('admin.access_denied');
    }
    }

    public function deleteImage($id, $name)
    {
        if(Auth::user()->hasPermission('update_product'))
        {
        $products = Product::where('trans_id', $id)->get();
        foreach($products as $product)
        {
            $images = explode(',', $product->image);
            $images_new = [];
            if(count($images))
            {
                foreach($images as $image)
                {
                    if($image !== $name)
                    {
                        $images_new[] = $image;
                    }
                }
                if(count($images_new))
                {
                    $product->image = implode(',', $images_new);
                    $product->save();
                }
                else{
                    return redirect()->back()->with('error', 'Product must have at least one image');
                }
            }
        }
        return redirect()->back()->with('success', 'Image has been deleted successfully.');
    }
    else{
        return view('admin.access_denied');
    }
    }

    public function changeStatus($id)
    {
        if(Auth::user()->hasPermission('active_inactive_product'))
        {
        $products = Product::where('trans_id', $id)->get();
        foreach($products as $product)
        {
            $product->is_active = $product->is_active == 1 ? 0 : 1;
            $product->save();
        }
        return redirect()->back()->with('success', 'Status has been changed.');
    }
    else{
        return redirect()->back()->with('error', __("admin.access_denied"));
    }
    }

    public function copyProducts()
    {
        $arabic = Product::where('lang_name', 'Arabic')->get();
        foreach($arabic as $ar)
        {
            Product::where('trans_id', $ar->trans_id)->where('lang_name', 'English')->update([
                'title_ar' => $ar->title,
                'nutritional_info_ar' => $ar->nutritional_info,
                'description_ar' => $ar->description
            ]);
        }
        return response()->json(['success' => true, 'status' => 200, 'message' => 'updated']);
    }
    public function copyCategories()
    {
        $arabic = Category::where('lang_name', 'Arabic')->get();
        foreach($arabic as $ar)
        {
            Category::where('trans_id', $ar->trans_id)->where('lang_name', 'English')->update([
                'title_ar' => $ar->title,
            ]);
        }
        return response()->json(['success' => true, 'status' => 200, 'message' => 'updated']);
    }
    public function deleteArabicProducts()
    {
        Product::where('lang_name', 'Arabic')->delete();
        return response()->json(['success' => true, 'status' => 200, 'message' => 'successfully deleted products']);
    }
    public function deleteArabicCategories()
    {
        Category::where('lang_name', 'Arabic')->delete();
        return response()->json(['success' => true, 'status' => 200, 'message' => 'successfully deleted categories']);
    }
}
