<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use DB;
use Validator;
class ProductController extends BaseController
{
    /**
     * @var array
     */
    protected $validation = ['title' => 'required|string|max:200', 'description' => 'required|string|max:160'];

    /**
     * @param \App\Http\Controllers\Admin\DataTables\CategoryDataTable $dataTable
     *
     * @return mixed
     */
    public function index()
    {   
        $catObj=Category::all();

      

        if(isset($_GET['lang_name'])){

          $per_page = 10;
          $lang_name=$_GET['lang_name'];
          if($lang_name=='ar'){
            $subObj=Product::where('is_active', 1)->where('products.lang_name','Arabic')
            ->select('products.*','categories.title as cat_title')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->paginate($per_page);
            
          } 
          else{
            $subObj=Product::where('is_active', 1)->where('products.lang_name','English')
            ->select('products.*','categories.title as cat_title')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->paginate($per_page);
          }
          
        }
        else{

          $subObj=Product::where('is_active', 1)->where('products.lang_name','English')
            ->select('products.*','categories.title as cat_title')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->paginate($per_page);
        }

        return response()->json([
          "success"=> true,
          'total_count' => $subObj->total(),
          "data"=> ProductResource::collection($subObj),
          "message"=>"Data fetched."
        ]);
    }

    public function getOfferProducts($lang)
    {
      $per_page = 10;
      if(strtoupper($lang) == 'AR')
      {
        $lang = 'Arabic';
      }
      else{
        $lang = 'English';
      }
      $products = Product::where('is_active', 1)->where('offer', '1')->where('lang_name', $lang)->orderby('updated_at', 'desc')->paginate($per_page);
      return response()->json([
        "success"=> true,
        'total_count' => $products->total(),
        "data"=> ProductResource::collection($products),
        "message"=>"Data fetched."
      ]);
    }

    public function getSingleProduct(Request $request)
    {
        
     $trans_id=$request->trans_id;
     $lang_name=$request->lang_name;
      if($lang_name=='ar'){

          $lang_name='Arabic';

      }
      else{
        $lang_name='English';
      }


              
    $objProd=Product::select('products.*','categories.title as cat_title')
    ->join('categories', 'categories.id', '=', 'products.category_id')
    ->where('products.trans_id',$trans_id)
    ->where('products.lang_name',$lang_name)
    ->first();
    //return $objProd;exit;
    //dd($objProd);
            if(is_null($objProd)){

                  return response()->json([
                    "success"=> true,
                    "data"=> [],
                    "message"=>"0"
                  ]);

            } 
            else{
            $arrImage=explode(',',$objProd->image);
            $imagesArr=[];
            $c=0;
            foreach($arrImage as $im){
                
                $imagesArr["$c"]= asset('uploads/categories/'. $im);
                $c++;
            }
            $data=array();
            $data['id']=$objProd->id;
            $data['trans_id']=$objProd->trans_id;
            $data['lang_name']=$objProd->lang_name;
            $data['title']=$objProd->title;
            $data['title_ar']=$objProd->title_ar;
            $data['product_size']=$objProd->product_size;
            $data['nutritional_info']=$objProd->nutritional_info;
            $data['nutritional_info_ar']=$objProd->nutritional_info_ar;
            $data['description']=$objProd->description;
            $data['description_ar']=$objProd->description_ar;
            $data['color_code']=is_null($objProd->color_code) ? "": $objProd->color_code;
            $data['video']=is_null($objProd->video) ? "": $objProd->video;
            $data['images']=$imagesArr;
            return response()->json([
                    "success"=> true,
                    "data"=> $data,
                    "message"=>"Data fetched"
                  ]);
           // return $data;
            
            
           /* return $this->sendResponse(ProductResource::collection($objProd), 'Data fetched.');*/

            }
    }
    public function getProducts(Request $request)
    {
      $per_page = 10;
              $id=$request->trans_id;

              $lang_name = $request->get('lang_name');
              if($lang_name=='ar'){
                $lang_name='Arabic';
              }
              else{
                 $lang_name='English';
              }
            $objProd=Product::where('is_active', 1)->select('products.*','categories.title as cat_title')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('products.category_id',$id)
            ->where('products.lang_name',$lang_name)
            ->orderby('updated_at', 'desc')
            ->paginate($per_page);
            if(count($objProd)==0){

                  return response()->json([
                    "success"=> true,
                    'total_count' => 0,
                    "data"=> [],
                    "message"=>"0"
                  ]);

            } 
            else{
              return response()->json([
                "success"=> true,
                'total_count' => $objProd->total(),
                "data"=> ProductResource::collection($objProd),
                "message"=>"Data fetched."
              ]);

            }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function create()
    {

       // return view('admin.forms.category', $this->formVariables('category', null));
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

        $input = $request->all();
        $slug=$input['title'];
        $validator = Validator::make($input, [
            'parent_id'=>'required',
            'title' => 'required',
            'description' => 'required',
            'image'=>'required',
            'nutritional_info'=>'required',
            'sku'=>'required',
            'product_size'=>'required'

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
         if($request->hasfile('image'))
          { 
              $file=$request->file('image');
              $qnames = $file->getClientOriginalName();
              $image['filePath'] = $qnames;
              $file->move(public_path().'/uploads/categories/', $qnames);  
              $qname= $qnames;  

                  //dd($qname);                         
      
         $arrRequest=[
            'title' =>$request->title,
            'product_size'=>$request->product_size,
            'sku'=>$request->sku,
            'nutritional_info'=>$request->nutritional_info,
            'category_id'=>$request->parent_id,
            'parent_id'=>$request->parent_id,
            'price'=>$request->price,
            'image'=>$qname,
            'trans_status'=>1,
            'lang_name'=>'English',
            'trans_id'=>$latestObj->id,
            'description' => $request->description,
         ]; 
              
         Product::insert($arrRequest);

         return response()->json([
            "success"=>true,
            "data"=>$arrRequest,
            "message"=>"Data created."
            ]);

        }

        //return redirect()->back()->with(['success'=>'Successfully added record!']);
         
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
       // return view('admin.show', ['object' => $category]);
    }

    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit($id)
    {       
        
        $productObj = Product::find($id);
        if (is_null($productObj)) {
            return $this->sendError('Data does not exist.');
        }
        else{
        return $this->sendResponse(new ProductResource($productObj), 'Data fetched.');
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

    public function updateProduct(Request $request)
    {
       if($request->hasfile('image'))
          {
              $file=$request->file('image');
              $qnames = $file->getClientOriginalName();
              $image['filePath'] = $qnames;
              $file->move(public_path().'/uploads/categories/', $qnames);  
              $qname= $qnames;  
                  //dd($qname);
         } else{

            $qname=$request->filename;
         }                                  
      
         $reqArr=[
            'title' =>$request->title,
            'category_id'=>$request->parent_id,
            'product_size'=>$request->product_size,
            'sku'=>$request->sku,
            'nutritional_info'=>$request->nutritional_info,
            'parent_id'=>$request->parent_id,
            'image'=>$qname,
            'description' => $request->description,
         ];

         Product::where('id',$request->id)->update($reqArr);
         
         return $this->sendResponse($reqArr, 'Data updated.');

        // 
      
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
       $id=$request->id;
       Product::where('trans_id',$id)->delete();
       return $this->sendResponse([], 'Data deleted.');
    }
}
