<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\TagRepositoryInterface;

class TagService extends BaseService
{
    protected $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        parent::__construct($tagRepository);

        $this->tagRepository = $tagRepository;
    }
}
