<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function chainQueryWhere(Builder $query, string $key, string $value);

    public function chainQueryWhereIn(Builder $query, string $key, array $arrayValue);

    public function createQuery();

    public function switchActiveRecursiveParent(int $categoryId, int $status);

    public function switchInactiveRecursiveChildren(int $categoryId, int $status);

    public function checkCategoryCanDelete(int $id);

    public function getCategoriesCanBeParent(int $id);
}
