<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Http\Controllers\Admin\DataTables\ArticleDataTable;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends AdminController
{
    /**
     * @var array
     */
    protected $validation = [
        'content'      => 'required|string',
        'category_id'  => 'required|integer',
        'description'  => 'required|string|max:200',
        'published_at' => 'required|string',
        'title'        => 'required|string|max:200'
    ];

    /**
     * @param \App\Http\Controllers\Admin\DataTables\ArticleDataTable $dataTable
     *
     * @return mixed
     */
    public function index(ArticleDataTable $dataTable)
    {
      
        $recipeObj=Article::where('article_image','!=',null)
        ->select('articles.*','categories.title as cat_title')
        ->join('categories', 'categories.id', '=', 'articles.category_id')
        ->orderBy('articles.id','Asc')
        ->get();
        
        return view('admin.recipe-listing',['recipeObj'=>$recipeObj]);

    }




    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function create()
    {
        $catView=view('admin.dynamic-cat-all');
        $myroute='add';
    return view('admin.forms.article',['myroute'=>$myroute,'catView'=>$catView], $this->formVariables('article', null, $this->options()));
    
    }


    public function translateArticle($id)
    {

        $dataObj=Article::where('id',$id)->first();
        //dd($dataObj);
        return view('admin.article-translation',['dataObj'=>$dataObj]);
    }

   public function translateArticleSave(Request $request)
   {
        $qname=$request->filename;
//dd($request->all());
        Article::insert([
            'title' =>$request->title,
            'category_id'=>$request->parent_id,
            'published_at'=>date('d-m-Y'),
            'article_image'=>$qname,
            'trans_status'=>1,
            'description' => $request->description,
            'trans_id'=>$request->trans_id,
            'lang_name'=>$request->lang_name,
            'content'=>$request->content,
            'created_at'=>date('d-m-Y H:i:s'),
            'updated_at'=>date('d-m-Y H:i:s'),

         ]);
         $latestObj=Article::orderBy('id','desc')->first();
        // dd($latestObj->id);
         Article::where('trans_id',$latestObj->trans_id)->update(['trans_status'=>1]); 
        
         return redirect('/admin/article/')->with(['success'=>'Successfully updated record!']);
  }
   public function translateArticleUpdate(Request $request)
   {
        $qname=$request->filename;
//dd($request->all());
        Article::where('id',$request->id)->update([
            'title' =>$request->title,
            'category_id'=>$request->parent_id,
            'published_at'=>date('d-m-Y'),
            'article_image'=>$qname,
            'trans_status'=>1,
            'description' => $request->description,
            'trans_id'=>$request->trans_id,
            'lang_name'=>$request->lang_name,
            'content'=>$request->content,
            'created_at'=>date('d-m-Y H:i:s'),
            'updated_at'=>date('d-m-Y H:i:s'),

         ]);

         return redirect('/admin/article/')->with(['success'=>'Successfully updated record!']);
  }

    public function translateArticleEdit($id)
    {
        $dataObj=Article::where('id',$id)->first();
        //dd($dataObj);
        return view('admin.edit-article-translation',['dataObj'=>$dataObj]);
       

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
        if($request->hasfile('recipe_image'))
          {
              $file=$request->file('recipe_image');
              $qnames = $file->getClientOriginalName();
              $image['filePath'] = $qnames;
              $file->move(public_path().'/uploads/categories/', $qnames);  
              $qname= $qnames;  


          } 

        if($request->get('recipe_form')=='recipe_form')
        {   
              
              Article::insert([
                'title'=>$request->title,
                'slug'=>strtolower($request->title),
                'description'=>$request->description,
                'content'=>$request->content,
                'article_image'=>$qname,
                'trans_status'=>0,
                'published_at'=>date('d-m-Y'),
                'category_id'=>$request->category_id,
                'created_at'=>date('d-m-Y H:i:s'),
                'updated_at'=>date('d-m-Y H:i:s'),
                'lang_name'=>'English',

              ]);

              $latestObj=Article::orderBy('id', 'desc')->first();

              $file=$request->file('recipe_image');
              $qnames = $file->getClientOriginalName();
              //dd($latestObj->id,$qnames);
              Article::where('id', $latestObj->id)->update([
                'trans_id'=>$latestObj->id,

              ]);
        }  

         return redirect('/admin/article')->with(['success'=>'Successfully added record!']); 
        //return $this->createFlashRedirect(Article::class, $request);
    }

    /**
     * @param \App\Models\Article $article
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function show(Article $article)
    {
        return view('admin.show', ['object' => $article]);
    }

    /**
     * @param \App\Models\Article $article
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit(Article $article)
    {
        $myroute='edit';
        $id=$article->category_id;
        //dd($id);
        $view=view('admin.dynamic-cat-all-edit-product',['id'=>$id]);

        return view('admin.forms.article',['view'=>$view,'myroute'=>$myroute], $this->formVariables('article', $article, $this->options()));
    }

    /**
     * @param \App\Models\Article $article
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update(Article $article, Request $request)
    {
         if($request->hasfile('recipe_image'))
          {
              $file=$request->file('recipe_image');
              $qnames = $file->getClientOriginalName();
              $image['filePath'] = $qnames;
              $file->move(public_path().'/uploads/categories/', $qnames);  
              $qname= $qnames;  


          } 
          else{
            $qname=$request->filename;
          }

        Article::where('id',$article->id)->update([
            'category_id'=>$request->category_id,
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'article_image'=>$qname,
        ]);
        //dd($article);
        return redirect('/admin/article')->with(['success'=>'Successfully updated record!']); 
        //return $this->saveFlashRedirect($article, $request);
    }

    /**
     * @param \App\Models\Article $article
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Article $article)
    {

    if(isset($_POST['id'])){
           $id=$_POST['id'];

           $obj=Article::where('id',$id)->first();
           
       if($obj->lang_name=='Arabic'){

        Article::where('trans_id',$obj->trans_id)->update(['trans_status'=>0]);
        Article::where('id',$id)->delete();
        



       }
       else{

       Article::where('trans_id',$id)->delete();

       }
    }
        return redirect()->back()->with(['success'=>'Successfully deleted!']);
    }

    /**
     * @return array
     */
    protected function options()
    {
        return ['options' => Category::pluck('title', 'id')];
    }
}
