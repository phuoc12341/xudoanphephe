<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

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

    public static function findByIds(array $ids = [], array $columns = ['*'], string $orderBy = 'updated_at', string $orderDes = 'desc')
    {
        return Post::with('tags')
            ->whereIn('category_id', $ids)
            ->orderBy($orderBy, $orderDes)
            ->limit(4)
            ->get($columns);
    }

    public function getFeaturePost()
    {
        return $this->model->where('order', '<=', 4)->orderBy('order')->get();
    }

    public function getPopularPosts()
    {
        return $this->model->orderBy('view')->limit(5)->get();
    }

    public function getLatestPosts()
    {
        return $this->model->orderBy('updated_at')->limit(6)->get();
    }
}
