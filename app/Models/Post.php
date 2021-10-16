<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
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
        'user_id',
        'title',
        'category_id',
        'slug',
        'status',
        'description',
        'image',
        'order',
        'view',
    ];

    const ACTIVE = 1;
    const INACTIVE = 0;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function menu()
    {
        return $this->morphMany(Menu::class, 'menuable');
    }

    /**
     * Get the post's link.
     *
     * @param  string  $value
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('posts.show', ['slug' => $this->slug, 'post' => $this->id]);
    }

    /**
     * Get the post's link.
     *
     * @param  string  $value
     * @return string
     */
    public function getImagePathAttribute()
    {
        return $this->image ? asset("storage-images/{$this->image}") : asset('assets/images/default-img.png');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->locale('vi')->isoFormat('D/M/YYYY');
    }

    public function getDetailUpdatedAtAttribute($value)
    {
        $castedTime  = Carbon::parse($value)->locale('vi')->isoFormat('dddd, D/M/YYYY HH:mm');

        return ucfirst($castedTime) . ' (GMT+7)';
    }
}
