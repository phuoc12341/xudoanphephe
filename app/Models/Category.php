<?php

namespace App\Models;

use App\Repositories\PostRepositoryInterface;
use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'order',
    ];

    // protected $appends = ['totalPost'];
    
    const ACTIVE = 1;
    const INACTIVE = 0;

    // One level child
    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Recursive children
    public function children()
    {
        return $this->child()->with('children');
    }

    // One level parent
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Recursive parents
    public function parents()
    {
        return $this->parent()->with('parent');
    }

    // public function childrenAppendTotalPost()
    // {
    //     return $this->append('totalPost')->hasMany(self::class, 'parent_id', 'id')->with('childrenAppendTotalPost');
    // }
    
    /**
     * Scope a query to only include active categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function menu()
    {
        return $this->morphMany(Menu::class, 'menuable');
    }

    /**
     * Get the menu's link.
     *
     * @param  string  $value
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('categories.show', ['slug' => $this->slug, 'category' => $this->id]);
    }

    /**
    * Get the user's full name.
    *
    * @return string
    */
    public function getFeaturedPostAttribute()
    {
        $ids = CategoryService::getParentAndRecursiveChildIds($this->id);

        return PostService::findByIds($ids);
    }

    public function getTotalPostAttribute()
    {
        return $this->total_post = CategoryService::getTotalPostByCategoryId($this->id);
    }
}
