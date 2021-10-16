<?php

namespace App\Services;

use App\Enums\MenuType;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\MenuRepositoryInterface;
use App\Repositories\PageRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use Carbon\Carbon;

class MenuService extends BaseService
{
    protected $menuRepository;
    protected $pageRepository;
    protected $categoryRepository;
    protected $postRepository;

    public function __construct(
        MenuRepositoryInterface $menuRepository,
        PageRepositoryInterface $pageRepository,
        CategoryRepositoryInterface $categoryRepository,
        PostRepositoryInterface $postRepository
    ) {
        parent::__construct($menuRepository);

        $this->menuRepository = $menuRepository;
        $this->pageRepository = $pageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    public function insertMenu(array $menus, int $rootMenuId, int $parentId = null)
    {
        $menuId = null;

        foreach ($menus as $key => $menu) {
            switch ($menu['type']) {
                case MenuType::External:
                    $menuId = $this->insertGetId([
                        'root_id' => $rootMenuId,
                        'parent_id' => $parentId,
                        'name' => $menu['name'],
                        'redirect' => $menu['redirect'] ?? 0,
                        'url' => $menu['url'],
                        'menuable_type' => MenuType::External,
                    ]);
    
                    break;
    
                case MenuType::Page:
                    $page = $this->pageRepository->findById($menu['refer_id']);
                    
                    $menuModel = $page->menu()->create([
                        'root_id' => $rootMenuId,
                        'parent_id' => $parentId,
                        'name' => $menu['name'],
                        'redirect' => $menu['redirect'] ?? 0,
                    ]);

                    $menuId = $menuModel->id;
    
                    break;
    
                case MenuType::Category:
                    $category = $this->categoryRepository->findById($menu['refer_id']);
    
                    $menuModel = $category->menu()->create([
                        'root_id' => $rootMenuId,
                        'parent_id' => $parentId,
                        'name' => $menu['name'],
                        'redirect' => $menu['redirect'] ?? 0,
                    ]);

                    $menuId = $menuModel->id;
    
                    break;
    
                case MenuType::Post:
                    $post = $this->postRepository->findById($menu['refer_id']);
    
                    $menuModel = $post->menu()->create([
                        'root_id' => $rootMenuId,
                        'parent_id' => $parentId,
                        'name' => $menu['name'],
                        'redirect' => $menu['redirect'] ?? 0,
                    ]);

                    $menuId = $menuModel->id;
    
                    break;
    
                default:
                    # code...
                    break;
            }

            if (array_key_exists('children', $menu)) {
                $this->insertMenu($menu['children'], $rootMenuId, $menuId);
            }

            return true;
        }
    }

    public function deleteMenuByid(int $id)
    {
        return $this->menuRepository->deleteMenuByid($id);
    }

    public function getTopMenu()
    {
        return $this->menuRepository->getTopMenu();
    }

    public function getFooterMenu()
    {
        return $this->menuRepository->getFooterMenu();
    }
}
