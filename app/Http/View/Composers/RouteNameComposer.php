<?php

namespace App\Http\View\Composers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class RouteNameComposer
{
    protected $users;

    public function __construct(Request $request)
    {
        $this->routeNames = [
            'categories' => [
                'index' => route('categories.index'),
                'store' => route('categories.store'),
                'status' => route('categories.switch_status'),
                'destroy' => route('categories.destroy', ['id' => '?']),
                'edit' => route('categories.edit', ['id' => '?']),
                'update' => route('categories.update', ['id' => '?']),
            ],
            'posts' => [
                'status' => route('posts.switch_status'),
                'destroy' => route('posts.destroy', ['id' => '?']),
            ],
        ];
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('routeNames', $this->routeNames);
    }
}
