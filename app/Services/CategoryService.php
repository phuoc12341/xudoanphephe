<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;

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
}
