<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\Arr;

class CategoryService extends BaseService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        parent::__construct($categoryRepository);

        $this->categoryRepository = $categoryRepository;
    }

    public function switchCategoryStatus(int $categoryId, int $status)
    {
        if ($status == Category::ACTIVE) {
            return $this->categoryRepository->switchActiveRecursiveParent($categoryId, $status);
        }
        
        if ($status == Category::INACTIVE) {
            return $this->categoryRepository->switchInactiveRecursiveChildren($categoryId, $status);
        }

        return false;
    }

    public function checkCategoryCanDelete(int $id)
    {
        return $this->categoryRepository->checkCategoryCanDelete($id);
    }

    public function getCategoriesCanBeParent(int $id)
    {
        return $this->categoryRepository->getCategoriesCanBeParent($id);
    }

    public static function getParentAndRecursiveChildIds(int $id)
    {
        return Arr::pluck(CategoryRepository::getParentAndRecursiveChild($id), 'id');
    }

    public function getHomeCategories()
    {
        return $this->categoryRepository->getHomeCategories();
    }

    public static function getTotalPostByCategoryId(int $id)
    {
        $result = CategoryRepository::getTotalPostByCategoryId($id);

        return Arr::pluck($result, 'total_post')[0];
    }

    public function getAdminCategories()
    {
        return $this->categoryRepository->getAdminCategories(['id', 'name', 'status', 'order']);
    }
}
