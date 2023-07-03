<?php

namespace App\Http\Controllers\Application;

use Illuminate\Support\Facades\Auth;
use App\Base\Services\SitemapService;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\User;

class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        //dd(1);
            return redirect('auth/login');
/*
        return view('app.articles', [
            'title' => getTitle(),
            'description' => getDescription(),
            'articles' => Article::published()->paginate(4)
        ]);*/
    }

    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCategory(Category $category)
    {
        return view('app.articles', [
            'title' => $category->title,
            'description' => $category->description,
            'articles' => Article::where('category_id', $category->id)->paginate(4)
        ]);
    }

    /**
     * @param \App\Models\Page $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPage(Page $page)
    {
        return view('app.content', ['object' => $page]);
    }

    /**
     * @param \App\Models\Article $article
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getArticle(Article $article)
    {
        return view('app.content', ['object' => $article]);
    }

    /**
     * @param \App\Base\Services\SitemapService $sitemapService
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSitemap(SitemapService $sitemapService)
    {
        return $sitemapService->render();
    }

    public function activeUser($user)
    {
        if(Auth::user()->hasPermission('active_inactive_user'))
        {
        $user->is_active = '1';
        $user->save();
        return redirect()->back()->with(['success'=>'User ('.$user->first_name.') activated successfully.']);
        }
        else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    public function inactiveUser($user)
    {
        if(Auth::user()->hasPermission('active_inactive_user'))
        {
        $user->is_active = '0';
        $user->save();
        return redirect()->back()->with(['success'=>'User ('.$user->first_name.') Inactivated successfully']);
        }
        else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    public function activeAdmin($user)
    {
        if(Auth::user()->hasPermission('active_inactive_admin'))
        {
        $user->is_active = '1';
        $user->save();
        return redirect()->back()->with(['success'=>'User ('.$user->first_name.') activated successfully.']);
        }
        else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    public function inactiveAdmin($user)
    {
        if(Auth::user()->hasPermission('active_inactive_admin'))
        {
        $user->is_active = '0';
        $user->save();
        return redirect()->back()->with(['success'=>'User ('.$user->first_name.') Inactivated successfully']);
        }
        else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    public function updatePassword($id) 
    {
        if(Auth::user()->hasPermission('update_user'))
        {
            $user = User::find($id);
            return view('admin.forms.password');
        }
        else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }
}
