<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

interface PageRepositoryInterface extends BaseRepositoryInterface
{
    public function chainQueryWhere(Builder $query, string $key, string $value);

    public function chainQueryWhereIn(Builder $query, string $key, array $arrayValue);

    public function createQuery();
}
