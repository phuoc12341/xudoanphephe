<?php

namespace App\Repositories;

use App\Helper\Helper;
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

    public function getPostOrderMax()
    {
        return $this->model->max('order');
    }

    public function deleteCurrentOrder(int $currentOrder = null)
    {
        return $this->model->where('order', '>', $currentOrder)->decrement('order');
    }

    public function addNewOrderOutOfRangeAvailableOrder(int $newOrder = null)
    {
        return $this->model->where('order', '>=', $newOrder)->increment('order');
    }

    public function increaseCurrentOrder(int $currentOrder = null, int $newOrder)
    {
        return $this->model->where('order', '>', $currentOrder)->where('order', '<=', $newOrder)->decrement('order');
    }

    public function decreaseCurrentOrder(int $currentOrder = null, int $newOrder)
    {
        return $this->model->where('order', '>=', $newOrder)->where('order', '<', $currentOrder)->increment('order');
    }

    public function paginateList(array $columns = ['*'], string $orderBy = 'updated_at', string $orderDes = 'desc')
    {
        $perPage = config('common.item_per_page');

        return $this->model
            ->orderByRaw("-`{$orderBy}` {$orderDes}")
            ->paginate($perPage, $columns);
    }

    public function getCategoryPostsWithoutFeature(array $categoryIds = [], array $columns = ['*'], string $orderBy = 'updated_at', string $orderDes = 'desc')
    {
        $perPage = config('common.item_per_page');
        $postCount = $this->model->count();
        $perPage = 4;

        $postIds = $this->model
            ->whereIn('category_id', $categoryIds)
            ->orderBy($orderBy, $orderDes)
            ->skip(5)
            ->take($postCount - 5)
            ->pluck('id');
        
        return $this->model
            ->whereIn('category_id', $categoryIds)
            ->orderBy($orderBy, $orderDes)
            ->whereIn('id', $postIds)
            ->paginate($perPage, $columns, 'page');
    }

    public function getFeatureCategoriesPosts(array $categoryIds = [], array $columns = ['*'], string $orderBy = 'updated_at', string $orderDes = 'desc')
    {
        return $this->model
            ->whereIn('category_id', $categoryIds)
            ->orderBy($orderBy, $orderDes)
            ->limit(5)
            ->get();
    }

    public function getCategoryPopularPosts(array $categoryIds = [])
    {
        return $this->model
            ->orderBy('view')
            ->whereIn('category_id', $categoryIds)
            ->limit(5)
            ->get();
    }
}
