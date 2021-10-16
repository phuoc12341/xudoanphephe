<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

interface MenuRepositoryInterface extends BaseRepositoryInterface
{
    public function chainQueryWhere(Builder $query, string $key, string $value);

    public function chainQueryWhereIn(Builder $query, string $key, array $arrayValue);

    public function createQuery();

    public function deleteMenuByid(int $id);

    public function getTopMenu();

    public function getFooterMenu();
}
