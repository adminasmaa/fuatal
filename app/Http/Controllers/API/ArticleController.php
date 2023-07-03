<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Article;
use App\Http\Resources\Article as ArticleResource;
   
class ArticleController extends BaseController
{

    public function index()
    {
          if(isset($_GET['lang_name'])){

             $lang_name=$_GET['lang_name'];
             if($lang_name=='ar'){
                 $Articles = Article::where('lang_name','Arabic')->get();
             }
             else{
                $Articles = Article::where('lang_name','English')->get();
             }

         }
         else{
            $Articles = Article::where('lang_name','English')->get();
         }
       
        return $this->sendResponse(ArticleResource::collection($Articles), 'Posts fetched.');
    }

    
    public function store(Request $request)
    {
        $input = $request->all();
        $slug=$input['title'];
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'recipe_image'=>'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $input['slug']=strtolower($slug);
        $Article = Article::create($input);

       if($request->hasfile('recipe_image'))
         {
              $file=$request->file('recipe_image');
              $qnames = $file->getClientOriginalName();
              $image['filePath'] = $qnames;
              $file->move(public_path().'/uploads/categories/', $qnames);  
              $qname= $qnames;  
        }

        $Article->where('id',$Article->id)->update(['article_image'=>$qname]);

        return $this->sendResponse(new ArticleResource($Article), 'Post created.');
    }

   
    public function show($id)
    {
        $Article = Article::find($id);
        if (is_null($Article)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new ArticleResource($Article), 'Post fetched.');
    }
    public function recipeDetail(Request $request)
    {

        
         $lang_name=$request->lang_name;
         $trans_id=$request->trans_id;
         if($lang_name=='ar'){
          $lang_name=='Arabic';
         }
         else{
          $lang_name=='English';
         }     

        $Article = Article::where(['trans_id'=>$trans_id,'lang_name'=>$lang_name])->first();
        if (is_null($Article)) {
            return $this->sendError('Record does not exist.');
        }
        return $this->sendResponse(new ArticleResource($Article), 'Post fetched.');
    }
    

    public function update(Request $request, Article $Article)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }


        if($request->hasfile('recipe_image'))
        { 
              $file=$request->file('recipe_image');
              $qnames = $file->getClientOriginalName();
              $image['filePath'] = $qnames;
              $file->move(public_path().'/uploads/categories/', $qnames);  
              $qname= $qnames; 

        }

        $Article->title = $input['title'];
        $Article->description = $input['description'];
        $Article->trans_status=1;
        $Article->lang_name='English';
        $Article->save();
        //$Article->trans_id=>$latestObj->id
        

        Article::where('id',$Article->id)->update(['trans_id'=>$Article->id]);
        
        return $this->sendResponse(new ArticleResource($Article), 'Post updated.');
    }
   
    public function destroy(Article $Article)
    {
        $Article->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}