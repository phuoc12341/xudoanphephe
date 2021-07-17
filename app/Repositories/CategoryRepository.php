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
}
