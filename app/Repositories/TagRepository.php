<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    public function __construct(Tag $model)
    {
        parent::__construct($model);
    }

    public function chainQueryWhere(Builder $query, string $key, string $value)
    {
        return $query->where($key, $value);
    }

    public function chainQueryWhereIn(Builder $query, string $key, array $arrayValue)
    {
        return $query->whereIn($key, $arrayValue);
    }

    public function createQuery()
    {
        return $this->model->query();
    }
}
