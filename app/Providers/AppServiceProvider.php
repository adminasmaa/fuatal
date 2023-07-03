<?php

namespace App\Providers;

use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\City;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Support\Facades\URL;
use DB;
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // URL::forceScheme('https');
        Schema::defaultStringLength(191);
//        Paginator::defaultView('pagination::bulma');
//        Paginator::defaultSimpleView('pagination::simple-bulma');
//        Paginator::useBootstrap();
//        $cityObj = City::all();
//        View::share('cityObj', $cityObj);
//
//        $langObj = DB::table('applanguages')->get();
//        View::share('langObj', $langObj);
//
//
//        $catObj=Category::all();
//        View::share('catObj', $catObj);
//
//        $pageObj=Page::all();
//        View::share('pageObj', $pageObj);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        $whitelist = [
//    // IPv4 address
//            '127.0.0.1',
//
//            // IPv6 address
//            '::1'
//        ];
//        if (isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
//    // do something...
//       }
//       else{
//        $this->app->bind('path.public', function() {
//            return base_path().'/public';
//        });
//        }
//        if ($this->app->environment() !== 'production') {
//            $this->app->register(IdeHelperServiceProvider::class);
//            $this->app->register(DebugbarServiceProvider::class);
//        }

    }
}
