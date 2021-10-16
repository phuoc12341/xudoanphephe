<?php

namespace App\Repositories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Builder;

class MenuRepository extends BaseRepository implements MenuRepositoryInterface
{
    public function __construct(Menu $model)
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

    public function deleteMenuByid(int $id)
    {
        return $this->model->where('root_id', $id)->delete();
    }
    
    public function getTopMenu()
    {
        return $this->model->whereNull('parent_id')->where('active_top', Menu::TOP_MENU)->first();
    }

    public function getFooterMenu()
    {
        return $this->model->whereNull('parent_id')->where('active_footer', Menu::FOOTER_MENU)->first();
    }
}
