<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Log;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        if (is_null($post->order)) {
            return;
        }

        $lowerPriorityPosts = Post::where('order', '>=', $post->order)->get();
        Log::debug("message");
        foreach ($lowerPriorityPosts as $post) {
            $post->order += $post->order;
            $post->saveQuietly();
        }
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        if (is_null($post->order)) {
            return;
        }

        $lowerPriorityPosts = Post::where('order', '>=', $post->order)->get();
        Log::debug("message");
        foreach ($lowerPriorityPosts as $post) {
            $post->order += $post->order;
            $post->saveQuietly();
        }
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
