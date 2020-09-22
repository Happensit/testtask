<?php

namespace App\Serializer\Normalizer;

use App\Entity\News;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;

/**
 * Class NewsNormalizer
 * @package App\Serializer\Normalizer
 */
class NewsNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    /**
     * @var ObjectNormalizer
     */
    private $normalizer;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * NewsNormalizer constructor.
     * @param ObjectNormalizer $normalizer
     * @param UrlGeneratorInterface $router
     */
    public function __construct(ObjectNormalizer $normalizer, UrlGeneratorInterface $router)
    {
        $this->normalizer = $normalizer;
        $this->router = $router;
    }

    /**
     * @param mixed $object
     * @param null $format
     * @param array $context
     * @return array
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($object, $format = null, array $context = array()): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        if(isset($context['show_format'])) {
            if (in_array('list_news', $context['show_format'])) {
                $data = $this->normalizeNewsTeaser($data);
            }

            unset($context['show_format']);
        }

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function normalizeNewsTeaser(array $data)
    {
        if (strlen($data['content']) > News::PREVIEW_SIZE) {
            $data['content'] = mb_substr($data['content'], 0, News::PREVIEW_SIZE).'...';
        }

        $data['link'] = $this->router->generate('news_show', ['id' => $data['id']]);
        unset($data['image']);

        return $data;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof \App\Entity\News;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
