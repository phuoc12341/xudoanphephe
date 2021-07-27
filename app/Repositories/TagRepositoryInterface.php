<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

interface TagRepositoryInterface extends BaseRepositoryInterface
{
    public function chainQueryWhere(Builder $query, string $key, string $value);

    public function chainQueryWhereIn(Builder $query, string $key, array $arrayValue);

    public function createQuery();
}
