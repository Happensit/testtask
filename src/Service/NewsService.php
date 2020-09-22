<?php

namespace App\Service;

use Throwable;
use App\Entity\News;
use App\Repository\NewsRepository;

/**
 * Class NewsService
 * @package App\Service
 */
final class NewsService
{
    /**
     * @var NewsRepository
     */
    private $newsRepository;

    /**
     * NewsService constructor.
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @return News[]
     */
    public function getLatestNews()
    {
        return $this->newsRepository->findBy([], ['id' => 'DESC'], News::NUMBER_OF_NEWS_TO_SHOW);
    }

    /**
     * @param int $id
     * @return News|null
     */
    public function getNewsById(int $id)
    {
        return $this->newsRepository->findOneBy(['id' => $id]);
    }

    /**
     *
     * @param News $news
     * @return bool
     */
    public function save(News $news)
    {
        try {
            $this->newsRepository->save($news);
        } catch (Throwable $e) {
            return false;
        }

        return true;
    }
}