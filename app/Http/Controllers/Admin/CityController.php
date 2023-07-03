<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Http\Controllers\Admin\DataTables\CategoryDataTable;
use App\Models\City;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;
class CityController extends AdminController
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
        $subObj=City::all();

        //dd($subObj);
        return view('admin.city',['subObj'=>$subObj]);
        //return $dataTable->render('admin.table', ['link' => route('admin.category.create')]);
    } 
    public function cities()
    {   
        $subObj=City::orderBy('trans_id','Asc')->get();

        //dd($subObj);
        return view('admin.city-listing',['subObj'=>$subObj]);
        //return $dataTable->render('admin.table', ['link' => route('admin.category.create')]);
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
         try{

         City::insert([
            'city_name' =>$request->city_name,
            'country_id'=>'Iraq',
            'trans_status'=>0,
            'lang_name'=>'English',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
         ]);

        
         $latestObj=City::orderBy('id', 'desc')->first();
         City::where('id',$latestObj->id)->update(['trans_id'=>$latestObj->id]);
       }

       catch(\Exception $e){
           return $e->getMessage();
         }
        

        return redirect()->back()->with(['success'=>'Successfully added record!']);
         
       // return $this->createFlashRedirect(Category::class, $request);
    }

    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function show($id)
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
        
        $cityObject=City::where('id',$id)->first();   

        //dd($cityObject); 
        return view('admin.city-edit', ['cityObject'=>$cityObject]);
    }

    public function translateCity($id)
    {       
        
        $cityObject=City::where('id',$id)->first();   

        //dd($cityObject); 
        return view('admin.city-translation', ['cityObject'=>$cityObject]);
    }

    public function translateCitySave(Request $request)
    { 
            City::insert([
            'city_name' =>$request->city_name,
            'country_id'=>'Iraq',
            'trans_id'=>$request->trans_id,
            'trans_status'=>1,
         ]);

            City::where('trans_id',$request->trans_id)->update([
                'trans_status'=>1,
            ]);
        

        return redirect('admin/listing/cities')->with(['success'=>'Successfully added record!']);

    }   
    public function edittranslateCity($id)
    {       
        
        $cityObject=City::where('id',$id)->first();   

        //dd($cityObject); 
        return view('admin.edit-city-translation', ['cityObject'=>$cityObject]);
    }

  public function translateCityUpdate(Request $request)
    {

        //dd($request->all()); 
        $input=$request->all();
                                       
         DB::table('cities')->where('id',$input['id'])->update([
            'city_name' =>$request->city_name,
            'country_id'=>'Iraq',
            'trans_status'=>1
         ]);
//dd($request->all()); 
        return redirect('/admin/listing/cities')->with(['success'=>'Successfully updated record!']);
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

    public function updateCity(Request $request)
    {

        //dd($request->all()); 
        $input=$request->all();
                                       
         DB::table('cities')->where('id',$input['id'])->update([
            'city_name' =>$request->city_name,
            'country_id'=>$request->country_id,
         ]);
//dd($request->all()); 
        return redirect('/admin/listing/cities')->with(['success'=>'Successfully updated record!']);
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

       $obj=City::where('id',$id)->first();
       if($obj->trans_status==1){
        //City::where('trans_id',$id)->
        City::where('id',$id)->delete();
       }
       else{
       City::where('trans_id',$id)->delete();
       }

    }
}
