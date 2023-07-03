<?php

namespace App\Http\Controllers\API;
use App\Models\Category;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Subcategory as SubcategoryResource;
class SubcategoryController extends BaseController
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

        $subObj=Subcategory::where('subcat_image','!=',null)
        ->select('subcategories.*','categories.title as cat_title')
        ->join('categories', 'categories.id', '=', 'subcategories.category_id')
        ->get();

        return $this->sendResponse(SubcategoryResource::collection($subObj), 'Data fetched.');
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function create()
    {

        //return view('admin.forms.category', $this->formVariables('category', null));
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
            'category_id'=>'required',
            'title' => 'required',
            'description' => 'required',
            'subcat_image'=>'required',

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

         if($request->hasfile('subcat_image'))
          {
              $file=$request->file('subcat_image');
              $qnames = $file->getClientOriginalName();
              $image['filePath'] = $qnames;
              $file->move(public_path().'/uploads/categories/', $qnames);  
              $qname= $qnames;  
                  //dd($qname);                         
      
          $arrRequest=[
            'title' =>$request->title,
            'category_id'=>$request->category_id,
            'parent_id'=>'1',
            'subcat_image'=>$qname,
            'description' => $request->description,
           ];

         Subcategory::insert($arrRequest);

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
    #params id of subcategory_id
    #url 
    public function show($subCatId)
    {
        
       $SubCategory = Subcategory::find($subCatId);
        if (is_null($SubCategory)) {
            return $this->sendError('Data does not exist.');
        }
        else{
        return $this->sendResponse(new SubcategoryResource($SubCategory), 'Data fetched.');
        }
       

     }

    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit($subCatId)
    {       
        $SubCategory = Subcategory::find($subCatId);
        if (is_null($SubCategory)) {
            return $this->sendError('Data does not exist.');
        }
        else{
        return $this->sendResponse(new SubcategoryResource($SubCategory), 'Data fetched.');
        }   
       // return view('admin.edit-sub-category', ['dataObj'=>$dataObj,'catObj'=>$catObj]);
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

   # POST request
    public function updateSubCategory(Request $request)
    {
       if($request->hasfile('subcat_image'))
          {
              $file=$request->file('subcat_image');
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
            'category_id'=>$request->category_id,
            'parent_id'=>'1',
            'subcat_image'=>$qname,
            'description' => $request->description,
         ];
         Subcategory::where('id',$request->id)->update($reqArr);

         return $this->sendResponse($reqArr, 'Data updated.');

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

    #POST REQUEST
    # PARAMS FORM DATA id.

    public function deleteRecord(Request $request)
    {
       $id=$request->id;
       Subcategory::where('id',$id)->delete();
       return $this->sendResponse([], 'Data deleted.');
      // return ['success'=>true,'data'=>null,'message'=>'Record Deleted!'];
    }
}
