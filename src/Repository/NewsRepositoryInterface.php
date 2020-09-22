<?php

namespace App\Repository;

use App\Entity\News;

/**
 * Interface NewsRepositoryInterface
 * @package App\Repository
 */
interface NewsRepositoryInterface
{
    /**
     * @param News $news
     * @return mixed
     */
    public function save(News $news);

}