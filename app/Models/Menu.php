<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use function PHPUnit\Framework\isEmpty;

class Menu extends Model
{
    use SoftDeletes;
    use HasFactory;

    const TOP_MENU = 1;
    const FOOTER_MENU = 1;

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
        'root_id',
        'parent_id',
        'name',
        'order',
        'redirect',
        'url',
    ];

    /**
     * Get the parent menuable model (page, category or post).
     */
    public function menuable()
    {
        return $this->morphTo();
    }

    // One level child
    public function child()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    // Recursive children
    public function children()
    {
        return $this->child()->with('children');
    }

    // One level parent
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Recursive parents
    public function parents()
    {
        return $this->parent()->with('parent');
    }

    /**
     * Get the menu's link.
     *
     * @param  string  $value
     * @return string
     */
    public function getLinkAttribute()
    {
        if (is_null($this->menuable)) {
            return $this->url;
        }
        
        return $this->menuable->link;
    }
}
