<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Http\Controllers\Admin\DataTables\PageDataTable;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends AdminController
{
    /**
     * @var array
     */
    protected $validation = [
        'content'     => 'required|string',
        'parent_id'   => 'nullable|integer',
        'description' => 'required|string|max:200',
        'title'       => 'required|string|max:200'
    ];

    /**
     * @param \App\Http\Controllers\Admin\DataTables\PageDataTable $dataTable
     *
     * @return mixed
     */
    public function index(PageDataTable $dataTable)
    {
        $pageObj=Page::all();
        
        return view('admin.page-listing',['pageObj'=>$pageObj]);
       // return $dataTable->render('admin.table', ['link' => route('admin.page.create')]);
    }



    public function translatePage($id)
    {

        $dataObj=Page::where('id',$id)->first();
        //dd($dataObj);
        return view('admin.page-translation',['dataObj'=>$dataObj]);
    }

   public function translatePageSave(Request $request)
   {
        $qname=$request->filename;
//dd($request->all());
        Page::insert([
            'title' =>$request->title,
            'parent_id'=>$request->parent_id,
            'page_image'=>$qname,
            'trans_status'=>1,
            'description' => $request->description,
            'trans_id'=>$request->trans_id,
            'lang_name'=>$request->lang_name,
            'content'=>$request->content,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),

         ]);

         $latestObj=Page::orderBy('id','desc')->first();
        
         Page::where('trans_id',$latestObj->trans_id)->update(['trans_status'=>1]); 
        

         return redirect('/admin/page/')->with(['success'=>'Successfully updated record!']);
  }

   public function translatePageUpdate(Request $request)
   {

        $qname=$request->filename;

        Page::where('id',$request->id)->update([
            'title' =>$request->title,
            'parent_id'=>$request->parent_id,
            'page_image'=>$qname,
            'trans_status'=>1,
            'description' => $request->description,
            'trans_id'=>$request->trans_id,
            'lang_name'=>$request->lang_name,
            'content'=>$request->content,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),

         ]);

         return redirect('/admin/page/')->with(['success'=>'Successfully updated record!']);
   }

    public function translatePageEdit($id)
    {
        $dataObj=Page::where('id',$id)->first();
        //dd($dataObj);
        return view('admin.edit-page-translation',['dataObj'=>$dataObj]);
       

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function create()
    {
        return view('admin.forms.page', $this->formVariables('page', null, $this->options()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store(Request $request)
    {
        return $this->createFlashRedirect(Page::class, $request);
    }

    /**
     * @param \App\Models\Page $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function show(Page $page)
    {
        return view('admin.show', ['object' => $page]);
    }

    /**
     * @param \App\Models\Page $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit(Page $page)
    {
        return view('admin.forms.page', $this->formVariables('page', $page, $this->options($page->id)));
    }

    /**
     * @param \App\Models\Page $page
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update(Page $page, Request $request)
    {
        return $this->saveFlashRedirect($page, $request);
    }

    /**
     * @param \App\Models\Page $page
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Page $page)
    {
        return $this->destroyFlashRedirect($page);
    }

    /**
     * @param null $id
     *
     * @return array
     */
    protected function options($id = null): array
    {
        return ['options' => Page::when($id !== null, function ($q) use ($id) {
            return $q->where('id', '!=', $id)->where('parent_id', null);
        })->pluck('title', 'id')];
    }
}
