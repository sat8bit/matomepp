<?php

namespace sat8bit\Matomepp\Command;;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use PhpAmqpLib\Message\AMQPMessage;

use sat8bit\Matomepp\Recommendation;
use Pimple;

class RecommendationAddCommand extends Command
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
            ->setName('recommendationadd')
            ->setDescription('add recommend keyword.')
            ->addArgument(
                'keyword',
                InputArgument::REQUIRED,
                'Recommend Keyword.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->container['recommendationRepo']->store(new Recommendation\Recommendation($input->getArgument('keyword')));
    }
}
