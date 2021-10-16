<?php

namespace App\View\Components;

use App\Services\PostService;
use Illuminate\View\Component;

class Latest extends Component
{
    public $latestPosts;
    public $popularPosts;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->latestPosts = $this->postService->getLatestPosts();
        $this->popularPosts = $this->postService->getPopularPosts();

        return view('web.components.latest');
    }
}
