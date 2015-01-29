<?php

namespace sat8bit\Matomepp\Command;;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use sat8bit\Matomepp\RSS;
use PDO;
use Pimple;

class RSSReadCommand extends Command
{
    /**
     * @var Pimple\Container
     */
    protected $container;

    /**
     * @param Pimple\Container
     */
    public function __construct(Pimple\Container $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('rssread')
            ->setDescription('RSS read')
            ->addArgument(
                'rss-url',
                InputArgument::REQUIRED,
                'RSS url.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('rss-url');

        $rss = new RSS\RSS($url);

        $this->container['rssRepo']->store($rss);
    }
}
