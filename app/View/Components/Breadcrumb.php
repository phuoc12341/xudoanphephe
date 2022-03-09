<?php

namespace App\View\Components;

use App\Enums\MenuType;
use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * The alert type.
     *
     * @var string
     */
    public $type;
 
    /**
     * The id of item.
     *
     * @var object
     */
    public $menuItem;
 

    protected $categories;
    protected $popularPosts;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $menuItem, CategoryService $categoryService, PostService $postService)
    {
        $this->type = $type;
        $this->menuItem = $menuItem;
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
        // dd($this->type, $this->menuItem);

        $breadcrumb = ['Trang chủ'];
        switch ($this->type) {
            // case MenuType::Page:
            //     $page = $this->pageRepository->findById($menu['refer_id']);
                
            //     $menuModel = $page->menu()->create([
            //         'root_id' => $rootMenuId,
            //         'parent_id' => $parentId,
            //         'name' => $menu['name'],
            //         'redirect' => $menu['redirect'] ?? 0,
            //     ]);

            //     $menuId = $menuModel->id;

            //     break;

            case MenuType::Post:
                $categories = $this->categoryService->getRecursiveParent($this->menuItem->category_id);
                $categoryBreadcrumb = array_reverse($categories);
                $breadcrumb = array_merge($breadcrumb, $categoryBreadcrumb);
                array_push($breadcrumb, $this->menuItem->title);

                break;

            case MenuType::Category:
                $categories = $this->categoryService->getRecursiveParent($this->menuItem->id);
                $categoryBreadcrumb = array_reverse($categories);
                array_pop($categoryBreadcrumb);
                $breadcrumb = array_merge($breadcrumb, $categoryBreadcrumb);
                array_push($breadcrumb, $this->menuItem->name);
// dd($breadcrumb);
                break;

            default:
                # code...
                break;
        }
        
        // $this->categories = $this->categoryService->getHomeCategories();
        // $this->popularPosts = $this->postService->getPopularPosts();
        
        return view('web.components.breadcrumb', ['breadcrumb' => $breadcrumb]);
    }
}
