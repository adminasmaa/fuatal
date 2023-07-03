<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Http\Controllers\Admin\DataTables\CategoryDataTable;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use DB;
class SubcategoryController extends AdminController
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

        return view('admin.sub-category',['catObj'=>$catObj,'subObj'=>$subObj]);
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
      

         Subcategory::insert([
            'title' =>$request->title,
            'category_id'=>$request->category_id,
            'parent_id'=>'1',
            'subcat_image'=>$qname,
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
        $dataObj=Subcategory::where('id',$id)->first();
        $catObj=Category::all();    
        return view('admin.edit-sub-category', ['dataObj'=>$dataObj,'catObj'=>$catObj]);
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
      

         Subcategory::where('id',$request->id)->update([
            'title' =>$request->title,
            'category_id'=>$request->category_id,
            'parent_id'=>'1',
            'subcat_image'=>$qname,
            'description' => $request->description,
         ]);

        

        return redirect('/admin/subcategory/')->with(['success'=>'Successfully updated record!']);
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
       Subcategory::where('id',$id)->delete();
    }
}
