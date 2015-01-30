<?php

namespace sat8bit\Matomepp\Command;;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Pimple;

class PickupTweetCommand extends Command
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
            ->setName('pickuptweet')
            ->setDescription('tweet pickup article.')
            ->addArgument(
                'article-id',
                InputArgument::OPTIONAL,
                'pickup target article identifer.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $articleId = $input->getArgument('article-id');

        if (!empty($articleId)) {
            $article = $this->container['articleRepo']->findByArticleId($articleId);
        } else {
            $article = $this->container['articleRepo']->findNewestArticleWithoutTweets();
        }

var_dump($article);

        if (empty($article)) {
            $output->writeln("no such article. article-id:$articleId");
            return;
        }

        $this->container['pickupTweetService']->provide($article);
    }
}
