<?php

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Pimple\Container();

$container['amqpConnection'] = function($c) {
    return new PhpAmqpLib\Connection\AMQPConnection('localhost', 5672, 'guest', 'guest');
};

$container['amqpChannelRssUrl'] = $container->factory(function($c) {
    $channel = $c['amqpConnection']->channel();
    $channel->queue_declare('rssurl', false, false, false, false);
    return $channel;
});

$container['recommendationRepo'] = $container->factory(function($c) {
    return new sat8bit\Matomepp\Recommendation\RecommendationRepository($c['pdo']);
});

$container['blogRepo'] = $container->factory(function($c) {
    return new sat8bit\Matomepp\Blog\BlogRepository($c['pdo']);
});

$container['rssRepo'] = $container->factory(function($c) {
    return new sat8bit\Matomepp\RSS\RSSRepository($c['pdo']);
});

$container['pdo'] = $container->factory(function($c) {
    $user = 'matomepp';
    $password = 'matomepp';
    return new PDO("mysql:dbname=matomepp;host=localhost;charset=utf8", $user, $password, array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));
});

return $container;
