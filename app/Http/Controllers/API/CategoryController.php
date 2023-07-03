<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Category;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Product as ProductResource;
use App\Models\Product;  
class CategoryController extends BaseController
{
    #GET request
    # must add Bearer token in  Authorization part of postman that generate at the time of login
    # Headers ['Accept'=>application/json]
    #url http://localhost/boiler/public/api/categories
    public function index()
    {
      $per_page = 10;
        if(isset($_GET['lang_name'])){

          $lang_name=$_GET['lang_name'];
          if($lang_name=='ar'){

            $Categorys = Category::where(['lang_name'=>'Arabic','parent_id'=>0])->orderby('id', 'desc')->paginate($per_page);
          } 
          else{

            $Categorys = Category::where(['lang_name'=>'English','parent_id'=>0])->orderby('id', 'desc')->paginate($per_page);
          }
          
        }
        else{

            $Categorys = Category::where(['lang_name'=>'English','parent_id'=>0])->orderby('id', 'desc')->paginate($per_page);
        }
        return response()->json([
          "success"=> true,
          'total_count' => $Categorys->total(),
          "data"=> CategoryResource::collection($Categorys),
          "message"=>"Data fetched."
      ]);
    }

    #POST request
    #see form data in Resources/Category
    # must add Bearer token in  Authorization part of postman that generate at the time of login
    # Headers ['Accept'=>application/json]
    #url http://localhost/boiler/public/api/categories
    
    public function store(Request $request)
    {
        $input = $request->all();
        $slug=$input['title'];
        $validator = Validator::make($input, [
            'title' => 'required',
            
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
         }

        $input['slug']=strtolower($slug);
        $Category = Category::create($input);
       
        //dd($Category);
        if($request->hasfile('cat_image'))
          {
              $file=$request->file('cat_image');
              $qnames = $file->getClientOriginalName();
              $image['filePath'] = $qnames;
              $file->move(public_path().'/uploads/categories/', $qnames);  
              $qname= $qnames;  
                  //dd($qname);  
              $latestObj=Category::orderBy('id','desc')->first();

              Category::where('id', $latestObj->id)->update([
                'parent_id'=>$input['parent_id'],
                'cat_image'=>$qname,
                'trans_status'=>0,
                'lang_name'=>'English',
                'trans_id'=>$latestObj->id

         ]);     
                $Category['cat_image']=$qname;       
         }
        return $this->sendResponse(new CategoryResource($Category), 'Data created.');
    }

    public function getCategories($lang)
    {
      $return_data = [];
        $lang = 'English';
      $categories = Category::where('lang_name', $lang)->where('parent_id', 0)->with('subCategories', function ($query) use ($lang){
        $query->where('lang_name', $lang);
      })->get();
      foreach($categories as $cat)
      {
        if(count($cat->subCategories) > 0)
        {
          $cat->sub_categories = $this->getSub($cat->subCategories, $lang);
        }
        else{
          $cat->sub_categories = [];
        }
      }
      return response()->json(['success'=>true, 'total_count' => $categories->count(), 'data'=>$categories, 'message'=>'Data fetched!']);
    }

    public function getSub($categories, $lang)
    {
      foreach($categories as $cat)
      {
        $subcategories = Category::where('lang_name', $lang)->where('parent_id', $cat->trans_id)->get();
        if(count($subcategories) > 0)
        $cat->sub_categories = $this->getSub($subcategories, $lang);
        else
        $cat->sub_categories = [];
      }
      return $categories;
    }

   public function getSubCategories(Request $request)
   {
     $per_page = 10;

      $id=$request->trans_id;
         $lang_name='English';

      $Category = Category::where(['parent_id'=>$id,'lang_name'=>$lang_name])->orderby('id', 'desc')->paginate($per_page);
      
        if(count($Category)>0){
           $categoryArr = array();
            foreach ($Category as $grade) {
                $categoryArr[] = array(
                    'id' => $grade->id,
                    'trans_id'=>$grade->trans_id,
                    'color_code'=>is_null($grade->color_code) ? "" : $grade->color_code,
                    'title' => $grade->title,
                    'title_ar' => $grade->title_ar,
                    'cat_image' => asset('uploads/categories/'. $grade->cat_image),
                    'description'=>$grade->description,
                );
            }
    
          return response()->json(['success'=>true, 'total_count' => $Category->total(), 'data'=>$categoryArr,'message'=>'Data fetched!']);

           
        }
        else{
          
          return response()->json([
                "success"=> true,
                'total_count' => 0,
                "data"=> [],
                "message"=>"0"
              ]);

        }
  }
    public function show($id)
    {
        $Category = Category::where('parent_id',$id)->get();
        if (is_null($Category)) {
            return $this->sendError('Data does not exist.');
        }
        return $this->sendResponse(new CategoryResource($Category), 'Data fetched.');
    }
    

    public function update(Request $request, Category $Category)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $parent_id=$input['parent_id'];
         if($parent_id==''){
            $parent_id=0;
         }
         
             

        $Category->title = $input['title'];
        $Category->description = $input['description'];
        $Category->parent_id = $parent_id;
        if($request->hasfile('cat_image'))
         {
             $file=$request->file('cat_image');
              $qnames = $file->getClientOriginalName();
              $image['filePath'] = $qnames;
              $file->move(public_path().'/uploads/categories/', $qnames);  
              $qname= $qnames;  
              $Category->cat_image = $qname;
          }
        $Category->save();
        
        return $this->sendResponse(new CategoryResource($Category), 'Data updated.');
    }
   
    public function destroy(Category $Category)
    {
        $Category->delete();
        return $this->sendResponse([], 'Data deleted.');
    }
}