<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BaseController
 * @package App\Controller
 */
class BaseController extends AbstractController
{
    /**
     * @param $data
     * @param array $context
     * @return JsonResponse
     */
    protected function customJson($data, $context = []): JsonResponse
    {
        return parent::json(['data' => $data], 200, [], $context);
    }
}