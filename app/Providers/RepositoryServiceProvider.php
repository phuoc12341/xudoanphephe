<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected static $repositories = [
        'base' => [
            \App\Repositories\BaseRepositoryInterface::class,
            \App\Repositories\BaseRepository::class,
        ],
        'user' => [
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class,
        ],
        'categories' => [
            \App\Repositories\CategoryRepositoryInterface::class,
            \App\Repositories\CategoryRepository::class,
        ],
        'posts' => [
            \App\Repositories\PostRepositoryInterface::class,
            \App\Repositories\PostRepository::class,
        ],
        'tags' => [
            \App\Repositories\TagRepositoryInterface::class,
            \App\Repositories\TagRepository::class,
        ],
        'pages' => [
            \App\Repositories\PageRepositoryInterface::class,
            \App\Repositories\PageRepository::class,
        ],
        'menus' => [
            \App\Repositories\MenuRepositoryInterface::class,
            \App\Repositories\MenuRepository::class,
        ],
    ];
    
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (static::$repositories as $repository) {
            $this->app->singleton(
                $repository[0],
                $repository[1]
            );
        }
    }
}
