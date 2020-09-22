<?php

namespace App\Parser;

/**
 * Interface RbcClientInterface
 * @package App\Parser
 */
interface RbcClientInterface
{
    /**
     * @param string $url
     * @return mixed
     */
    public function fetchContent(string $url);
}