<?php

namespace App\Command;

use App\Service\ParserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ParserCommand
 * @package App\Command
 */
abstract class ParserCommand extends Command
{
    /**
     * @var ParserService
     */
    protected $parser;

    /**
     * ParserCommand constructor.
     * @param ParserService $parser
     * @param string|null $name
     */
    public function __construct(ParserService $parser, string $name = null)
    {
        $this->parser = $parser;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Parsing command');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->parser->parse();

        $io->success('Done parse!');

        return self::SUCCESS;
    }
}
