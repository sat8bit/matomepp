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
            )
            ->addOption(
                'newest',
                null,
                InputOption::VALUE_NONE,
                'tweet newest article.'
            )
            ->addOption(
                'random',
                null,
                InputOption::VALUE_NONE,
                'tweet random article.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $articleId = $input->getArgument('article-id');

        if (!empty($articleId)) {
            $article = $this->container['articleRepo']->findByArticleId($articleId);
            return $this->container['pickupTweetService']->provide($article, '【ピックアップ】');
        }

        if ($input->getOption('newest')) {
            $article = $this->container['articleRepo']->findNewestArticleWithoutTweets();
            return $this->container['pickupTweetService']->provide($article, '【新着】');
        }

        if ($input->getOption('random')) {
            $article = $this->container['articleRepo']->findRandomArticleWithoutTweets();
            return $this->container['pickupTweetService']->provide($article, '【発掘】');
        }

        throw new \InvalidArgumentException('input article-id or option.');
    }
}
