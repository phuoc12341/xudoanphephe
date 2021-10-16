<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class PostService extends BaseService
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        parent::__construct($postRepository);

        $this->postRepository = $postRepository;
    }

    public function deleteById(int $id)
    {
        $post = $this->findById($id);
        $post->tags()->detach();
        Storage::delete("images/{$post->image}");
        $deletedRows = $post->delete();
        
        return $deletedRows;
    }

    public static function findByIds(array $ids)
    {
        return PostRepository::findByIds($ids);
    }

    public function getFeaturePost()
    {
        return $this->postRepository->getFeaturePost();
    }

    public function getPopularPosts()
    {
        return $this->postRepository->getPopularPosts();
    }

    public function getLatestPosts()
    {
        return $this->postRepository->getLatestPosts();
    }
}
