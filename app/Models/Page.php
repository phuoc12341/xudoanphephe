<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

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
        $test = $this->slug;
        
        return $test;
    }
}
