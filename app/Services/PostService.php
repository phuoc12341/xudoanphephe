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

    public function getCategoryPostsWithoutFeature(array $ids)
    {
        return $this->postRepository->getCategoryPostsWithoutFeature($ids);
    }

    public function getFeatureCategoriesPosts(array $ids)
    {
        return $this->postRepository->getFeatureCategoriesPosts($ids);
    }

    public function getCategoryPopularPosts(array $ids)
    {
        return $this->postRepository->getCategoryPopularPosts($ids);
    }

    public function reIndexOrder(int $currentOrder = null, int $newOrder = null)
    {
        $maxOrder = $this->postRepository->getPostOrderMax();
        if ($maxOrder == null) {
            $maxOrder = 1;
        }

        if ($newOrder === 0) {
            return null;
        }
        
        if ($newOrder === null) {
            if ($currentOrder !== null) {
                $this->postRepository->deleteCurrentOrder($currentOrder);
            }
        } else {
            if ($currentOrder == null) {
                if ($newOrder > $maxOrder) {
                    return ++$maxOrder;
                } else {
                    $this->postRepository->addNewOrderOutOfRangeAvailableOrder($newOrder);
                }
            } else {
                if ($newOrder > $currentOrder) {
                    $this->postRepository->increaseCurrentOrder($currentOrder, $newOrder);
                }
        
                if ($newOrder < $currentOrder) {
                    $this->postRepository->decreaseCurrentOrder($currentOrder, $newOrder);
                }
            }
        }

        return ($newOrder <= $maxOrder) ? $newOrder : $maxOrder;
    }
}
