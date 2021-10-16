<?php

namespace App\View\Components;

use App\Services\PostService;
use Illuminate\View\Component;

class FeaturePost extends Component
{
    public $featurePost;
    
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
        $this->featurePost = $this->postService->getFeaturePost();

        return view('web.components.feature-post');
    }
}
