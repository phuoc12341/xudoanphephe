<?php

namespace App\Services;

use App\Repositories\PageRepositoryInterface;

class PageService extends BaseService
{
    protected $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        parent::__construct($pageRepository);

        $this->pageRepository = $pageRepository;
    }
}
