<?php

namespace App\Service;

use App\Parser\ParserInterface;

/**
 * Class ParserService
 * @package App\Service
 */
final class ParserService implements ParserInterface
{
    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * ParserService constructor.
     * @param ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @return mixed|void
     */
    public function parse()
    {
        return $this->parser->parse();
    }
}