<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function __construct(Post $model)
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

    public function fetchAll(array $columns = ['*'])
    {
        return $this->model->with('tags')->get();
    }

    public function findById(int $id, array $columns = ['*'])
    {
        return $this->model->with('tags')->find($id, $columns);
    }
}
