<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'page' => 'App\Models\Page',
            'category' => 'App\Models\Category',
            'post' => 'App\Models\Post',
            'external' => 'App\Models\Menu',
        ]);

        Paginator::useBootstrap();
    }
}
