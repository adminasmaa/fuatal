<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Page;
use App\Http\Resources\Page as PageResource;
   
class PageController extends BaseController
{

    public function index()
    {
        $Pages = Page::all();
        return $this->sendResponse(PageResource::collection($Pages), 'Posts fetched.');
    }

    
    public function store(Request $request)
    {
        $input = $request->all();
        $slug=$input['title'];
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $input['slug']=strtolower($slug);
        $Page = Page::create($input);
        return $this->sendResponse(new PageResource($Page), 'Post created.');
    }

   
    public function show($id)
    {
        $Page = Page::find($id);
        if (is_null($Page)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new PageResource($Page), 'Post fetched.');
    }
    

    public function update(Request $request, Page $Page)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $Page->title = $input['title'];
        $Page->description = $input['description'];
        $Page->save();
        
        return $this->sendResponse(new PageResource($Page), 'Post updated.');
    }
   
    public function destroy(Page $Page)
    {
        $Page->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}