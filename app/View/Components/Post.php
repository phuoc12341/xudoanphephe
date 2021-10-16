<?php

namespace App\View\Components;

use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\View\Component;

class Post extends Component
{
    public $categories;
    public $popularPosts;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CategoryService $categoryService, PostService $postService)
    {
        $this->categoryService = $categoryService;
        $this->postService = $postService;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->categories = $this->categoryService->getHomeCategories();
        $this->popularPosts = $this->postService->getPopularPosts();
        
        return view('web.components.post');
    }
}
