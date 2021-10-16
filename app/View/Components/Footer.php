<?php

namespace App\View\Components;

use App\Services\MenuService;
use App\Services\PostService;
use Illuminate\View\Component;

class Footer extends Component
{
    public $footerMenu;
    public $popularPosts;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(MenuService $menuService, PostService $postService)
    {
        $this->menuService = $menuService;
        $this->postService = $postService;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->footerMenu = $this->menuService->getFooterMenu();
        $this->popularPosts = $this->postService->getPopularPosts();
        
        return view('web.components.footer');
    }
}
