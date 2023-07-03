<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Http\Controllers\Admin\DataTables\CategoryDataTable;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Subcategoryfinal;
use App\Models\Subcategorythree;
use Illuminate\Http\Request;
class LevelthreesubcategoryController extends AdminController
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


        $subObj=Subcategorythree::where('subcat_image_three','!=',null)
        ->select('subcategorythrees.*','subcategoryfinals.title as cat_title')
        ->join('subcategoryfinals', 'subcategoryfinals.id', '=', 'subcategorythrees.subcategoryfinal_id')
        ->get();
        //dd($subObj);

        return view('admin.sub-category-three',['subcatObj'=>$subcatObj,'catObj'=>$catObj,'subObj'=>$subObj]);
        //return $dataTable->render('admin.table', ['link' => route('admin.category.create')]);
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
         if($request->hasfile('subcat_image'))
          {
              $file=$request->file('subcat_image');
              $qnames = $file->getClientOriginalName();
              $image['filePath'] = $qnames;
              $file->move(public_path().'/uploads/categories/', $qnames);  
              $qname= $qnames;  
                  //dd($qname);                         
      

         Subcategorythree::insert([
            'title' =>$request->title,
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'subcategoryfinal_id'=>$request->subcategoryfinal_id,
            'parent_id'=>'1',
            'subcat_image_three'=>$qname,
            'description' => $request->description,
         ]);

        }

        return redirect()->back()->with(['success'=>'Successfully added record!']);
         
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
        $dataObj=Subcategorythree::where('id',$id)->first();
        $subCatfinalObj=Subcategoryfinal::all();
        $subCatObj=Subcategory::all();
        $catObj=Category::all();    
        return view('admin.edit-sub-category-three', ['subCatfinalObj'=>$subCatfinalObj,'subCatObj'=>$subCatObj,'dataObj'=>$dataObj,'catObj'=>$catObj]);
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
      

         Subcategorythree::where('id',$request->id)->update([
            'title' =>$request->title,
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'parent_id'=>'1',
            'subcat_image_three'=>$qname,
            'description' => $request->description,
         ]);

        

        return redirect('/admin/subcategorythree')->with(['success'=>'Successfully updated record!']);
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
       Subcategorythree::where('id',$id)->delete();
    }

    public function fetchSubcategory(Request $request)
    {
        $id=$request->id;
        $obj=Subcategory::where('category_id',$id)->get();
        $html='<option value="">--Select--</option>';
          foreach ($obj as $sub) {
            $html.='<option value="'.$sub->id.'">'.$sub->title.'</option>';
          }
        
          return $html;

    }

 public function fetchSubcategoryfinal(Request $request)
    {
        $id=$request->id;
        $obj=Subcategoryfinal::where('subcategory_id',$id)->get();
        $html='<option value="">--Select--</option>';
          foreach ($obj as $sub) {
            $html.='<option value="'.$sub->id.'">'.$sub->title.'</option>';
          }
        
          return $html;

    }
}
