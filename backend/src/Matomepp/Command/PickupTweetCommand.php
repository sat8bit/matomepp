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
                InputArgument::REQUIRED,
                'pickup target article identifer.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $articleId = $input->getArgument('article-id');

        $article = $this->container['articleRepo']->findByArticleId($articleId);

        if (empty($article)) {
            $output->writeln("no such article. article-id:$articleId");
            return;
        } else {
            $output->writeln("article_id:$articleId");
            $output->writeln("title:{$article->getTitle()}");
        }
        $this->container['pickupTweetService']->provide($article);
    }
}
