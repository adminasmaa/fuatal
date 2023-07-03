<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Subcategory as SubcategoryResource;
use App\Http\Resources\Subcategoryfinal as SubcategoryfinalResource;
use App\Models\Subcategoryfinal;
class LeveltwosubcategoryController extends BaseController
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
        $subcatObj=Subcategory::all();


        $subObj=Subcategoryfinal::where('subcat_image_final','!=',null)
        ->select('subcategoryfinals.*','subcategories.title as cat_title')
        ->join('subcategories', 'subcategories.id', '=', 'subcategoryfinals.subcategory_id')
        ->get();
         return $this->sendResponse(SubcategoryfinalResource::collection($subObj), 'Data fetched.');

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

         $validator = Validator::make($input, [
            'category_id'=>'required',
            'subcategory_id'=>'required',
            'title' => 'required',
            'description' => 'required',
            'subcat_image_final'=>'required',

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

         if($request->hasfile('subcat_image_final'))
          {
              $file=$request->file('subcat_image_final');
              $qnames = $file->getClientOriginalName();
              $image['filePath'] = $qnames;
              $file->move(public_path().'/uploads/categories/', $qnames);  
              $qname= $qnames;  
                  //dd($qname);                         
      
          $arrRequest= [
            'title' =>$request->title,
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'parent_id'=>'1',
            'subcat_image_final'=>$qname,
            'description' => $request->description,
          ];   

         Subcategoryfinal::insert($arrRequest);


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
    public function show($subCatIdFinal)
    {

         $SubCategoryfinal = SubCategoryfinal::find($subCatIdFinal);
        if (is_null($SubCategory)) {
            return $this->sendError('Data does not exist.');
        }
        else{
        return $this->sendResponse(new SubcategoryfinalResource($SubCategoryfinal), 'Data fetched.');
        }
        //dd($category);
        // $dataTable=new CategoryDataTable; 
        //return view('admin.show', ['object' => $category]);
    }

    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit($subCatIdFinal)
    {       
        $SubCategoryfinal = SubCategoryfinal::find($subCatIdFinal);
        if (is_null($SubCategory)) {
            return $this->sendError('Data does not exist.');
        }
        else{
        return $this->sendResponse(new SubcategoryfinalResource($SubCategoryfinal), 'Data fetched.');
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

    public function updateSubCategoryfinal(Request $request)
    {
       if($request->hasfile('subcat_image_final'))
          {
              $file=$request->file('subcat_image_final');
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
            'subcategory_id'=>$request->subcategory_id,
            'parent_id'=>'1',
            'subcat_image_final'=>$qname,
            'description' => $request->description,
         ];

         Subcategoryfinal::where('id',$request->id)->update();

        
         return $this->sendResponse($reqArr, 'Data updated.');
       // return redirect('/admin/subcategoryfinal')->with(['success'=>'Successfully updated record!']);
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

    public function deleteRecordFinal(Request $request)
    {
       $id=$request->id;
       
       Subcategoryfinal::where('id',$id)->delete();

       return $this->sendResponse([], 'Data deleted.');

    }

    public function fetchSubcategory(Request $request)
    {
        $id=$request->id;
        
        $obj=Subcategory::where('category_id',$id)->get();
       
        return response()->json([
            "success"=>true,
            "data"=>$obj,
            "message"=>"Data fetched."

            ]);

        /*$html='<option value="">--Select--</option>';
          foreach ($obj as $sub) {
            $html.='<option value="'.$sub->id.'">'.$sub->title.'</option>';
          }*/
        
         // return $html;

    }
}
