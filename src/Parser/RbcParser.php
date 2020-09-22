<?php

namespace App\Parser;

use App\Entity\News;
use App\Service\NewsService;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class RbcParser
 * @package App\Parser
 */
class RbcParser implements ParserInterface
{
    protected const LIMIT = 15;
    protected const BASE_URL = 'https://www.rbc.ru/';
    protected const BASE_PATH = 'v10/ajax/get-news-feed/project/rbcnews.spb_sz/lastDate/%d/limit/%d?';
    protected const TITLE_SELECTOR = 'meta[property="og:title"]';
    protected const IMAGE_SELECTOR = 'meta[property="og:image"]';
    protected const CONTENT_SELECTOR = 'div[itemprop="articleBody"] p';

    /**
     * @var RbcClientInterface
     */
    protected $client;

    /**
     * @var NewsService
     */
    protected $newsService;

    /**
     * RbcParser constructor.
     * @param RbcClientInterface $client
     * @param NewsService $newsService
     */
    public function __construct(RbcClientInterface $client, NewsService $newsService)
    {
        $this->client = $client;
        $this->newsService = $newsService;
    }

    /**
     * @return string
     */
    private function prepareParseLink()
    {
        return self::BASE_URL . sprintf(self::BASE_PATH, time(), self::LIMIT);
    }

    /**
     * @return mixed
     */
    public function parse()
    {
        $data = json_decode($this->client->fetchContent($this->prepareParseLink()), true);

        foreach ($data['items'] as $item) {
            $crawler = new Crawler(trim($item['html']));
            $nodeLink = $crawler->filter('a')->first();
            $extid = $nodeLink->attr('id');
            $link = $nodeLink->attr('href');

            $fullNewsCrawler = new Crawler($this->client->fetchContent($link));
            $title = $fullNewsCrawler->filter(self::TITLE_SELECTOR)->attr('content');
            $image = $fullNewsCrawler->filter(self::IMAGE_SELECTOR)->attr('content');
            $content = $fullNewsCrawler->filter(self::CONTENT_SELECTOR)->each(function (Crawler $node) {
                return trim($node->text());
            });

            if (empty($content)) {
                continue;
            }

            $content = trim(implode(' ', $content));

            $this->newsService->save((new News())
                ->setExtid($extid)
                ->setTitle($title)
                ->setImage($image)
                ->setContent($content)
                ->setCreated((new \DateTime())->setTimestamp($item['publish_date_t']))
            );
        }

        return true;
    }

}