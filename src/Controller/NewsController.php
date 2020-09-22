<?php

namespace App\Controller;

use App\Service\NewsService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class NewsController
 * @package App\Controller
 */
class NewsController extends BaseController
{
    /**
     * @var NewsService
     */
    private $newsService;

    /**
     * NewsController constructor.
     * @param NewsService $newsService
     */
    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @return JsonResponse
     */
    public function list()
    {
        return $this->customJson($this->newsService->getLatestNews(), [
            'show_format' => ['list_news']
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return $this->customJson($this->newsService->getNewsById($id));
    }
}