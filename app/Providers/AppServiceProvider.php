<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('navigationPages', Page::where('status', 'published')
                ->where('show_in_nav', true)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get());
            $view->with('siteSettings', SiteSetting::current());
        });
    }
}
