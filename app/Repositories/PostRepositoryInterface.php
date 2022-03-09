<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function chainQueryWhere(Builder $query, string $key, string $value);

    public function chainQueryWhereIn(Builder $query, string $key, array $arrayValue);

    public function createQuery();

    public function fetchAll(array $columns = ['*']);

    public static function findByIds(array $ids = []);

    public function getFeaturePost();

    public function getPopularPosts();

    public function getLatestPosts();

    public function getPostOrderMax();

    public function deleteCurrentOrder(int $currentOrder = null);

    public function addNewOrderOutOfRangeAvailableOrder(int $newOrder = null);

    public function increaseCurrentOrder(int $currentOrder = null, int $newOrder);

    public function decreaseCurrentOrder(int $currentOrder = null, int $newOrder);

    public function getCategoryPostsWithoutFeature(array $categoryIds = [], array $columns = ['*'], string $orderBy = 'updated_at', string $orderDes = 'desc');

    public function getFeatureCategoriesPosts(array $categoryIds = [], array $columns = ['*'], string $orderBy = 'updated_at', string $orderDes = 'desc');

    public function getCategoryPopularPosts(array $categoryIds = []);
}
