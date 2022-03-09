<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
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
        return $this->model->whereNull('parent_id')->with('children')->get($columns);
    }

    public function switchActiveRecursiveParent(int $categoryId, int $status)
    {
        $rawQuery = "WITH RECURSIVE parent_cte AS (
            SELECT
                id,
                parent_id,
                name
            FROM
                categories
            WHERE
                id = ?
            AND deleted_at IS NULL
            UNION ALL
                (
                    SELECT
                        parent.id,
                        parent.parent_id,
                        parent.name
                    FROM
                        categories AS parent
                    INNER JOIN parent_cte ON parent.id = parent_cte.parent_id
                    WHERE
                        deleted_at IS NULL
                )
        ) UPDATE categories
        RIGHT JOIN parent_cte ON categories.id = parent_cte.id
        SET STATUS = ?";

        $expression = DB::raw($rawQuery);

        return DB::update($expression, [
            $categoryId,
            $status,
        ]);
    }

    public function switchInactiveRecursiveChildren(int $categoryId, int $status)
    {
        $rawQuery = "WITH RECURSIVE child_cte AS (
            SELECT
                id,
                parent_id,
                name
            FROM
                categories
            WHERE
                id = ?
            AND deleted_at IS NULL
            UNION ALL
                SELECT
                    child.id,
                    child.parent_id,
                    child.name
                FROM
                    categories AS child
                INNER JOIN child_cte ON child.parent_id = child_cte.id
                WHERE
                    deleted_at IS NULL
        ) UPDATE categories
        RIGHT JOIN child_cte ON categories.id = child_cte.id
        SET STATUS = ?";

        $expression = DB::raw($rawQuery);

        return DB::update($expression, [
            $categoryId,
            $status,
        ]);
    }

    public function checkCategoryCanDelete(int $id)
    {
        return $this->model->where('id', $id)->doesntHave('child')->first();
    }

    public function getCategoriesCanBeParent(int $categoryId)
    {
        $rawQuery = "WITH RECURSIVE child_cte AS (
            SELECT
                id,
                parent_id,
                name
            FROM
                categories
            WHERE
                id = ?
            AND deleted_at IS NULL
            UNION ALL
                SELECT
                    child.id,
                    child.parent_id,
                    child.name
                FROM
                    categories AS child
                INNER JOIN child_cte ON child.parent_id = child_cte.id
                WHERE
                    deleted_at IS NULL
        ) SELECT
            id,
            parent_id,
            name
        FROM
            categories
        WHERE
            deleted_at IS NULL
        AND NOT EXISTS (
            SELECT
                *
            FROM
                child_cte
            WHERE
                categories.id = child_cte.id
        )";

        $expression = DB::raw($rawQuery);

        return DB::select($expression, [
            $categoryId,
        ]);
    }

    public static function getParentAndRecursiveChild(int $categoryId)
    {
        $rawQuery = "WITH RECURSIVE parent_cte AS (
            SELECT
                id,
                parent_id,
                name
            FROM
                categories
            WHERE
                id = ?
            AND deleted_at IS NULL
            UNION ALL
                (
                    SELECT
                        child.id,
                        child.parent_id,
                        child.name
                    FROM
                        categories AS child
                    INNER JOIN parent_cte ON child.parent_id = parent_cte.id
                    WHERE
                        child.deleted_at IS NULL
                )
        ) select * from parent_cte";

        $expression = DB::raw($rawQuery);

        return DB::select($expression, [
            $categoryId,
        ]);
    }

    public function getRecursiveParent(int $categoryId)
    {
        $rawQuery = "WITH RECURSIVE parent_cte AS (
            SELECT
                id,
                parent_id,
                name,
                slug
            FROM
                categories
            WHERE
                id = ?
            AND deleted_at IS NULL
            UNION ALL
                (
                    SELECT
                        parent.id,
                        parent.parent_id,
                        parent.name,
                        parent.slug
                    FROM
                        categories AS parent
                    INNER JOIN parent_cte ON parent.id = parent_cte.parent_id
                    WHERE
                        deleted_at IS NULL
                )
        ) select * from parent_cte";

        $expression = DB::raw($rawQuery);

        return DB::select($expression, [
            $categoryId,
        ]);
    }

    public function getHomeCategories()
    {
        return $this->model->where('order', '<=', 3)->orderBy('order')->get();
    }

    public static function getTotalPostByCategoryId(int $categoryId)
    {
        $rawQuery = "SELECT
                count(*) AS total_post
            FROM
                posts
            WHERE
                category_id IN (
                WITH RECURSIVE parent_cte AS (
                    SELECT
                        id,
                        parent_id,
                        name
                    FROM
                        categories
                    WHERE
                        id = ?
                    AND deleted_at IS NULL
                    UNION ALL
                        (
                            SELECT
                                child.id,
                                child.parent_id,
                                child.name
                            FROM
                                categories AS child
                            INNER JOIN parent_cte ON child.parent_id = parent_cte.id
                            WHERE
                                child.deleted_at IS NULL
                        )
                ) SELECT
                    id
                FROM
                    parent_cte
            )";

        $expression = DB::raw($rawQuery);

        return DB::select($expression, [
            $categoryId,
        ]);
    }

    public function getAdminCategories(array $columns = ['*'])
    {
        return $this->model->with('childrenAppendTotalPost')->whereNull('parent_id')->get($columns);
    }

    public function getParentCategories(array $columns = ['*'])
    {
        return $this->model->isParent()->get($columns);
    }
}
