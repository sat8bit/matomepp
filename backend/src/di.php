<?php

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Pimple\Container();

$container['amqpConnection'] = function($c) {
    return new PhpAmqpLib\Connection\AMQPConnection('localhost', 5672, 'guest', 'guest');
};

$container['pickupTweetService'] = function($c) {
    return new sat8bit\Matomepp\Service\PickupTweetService($c['twitteroauth']);
};

$container['twitteroauth'] = function($c) {
    $consumerKey = $c['twitterConfig']['consumer_key'];
    $consumerSecret = $c['twitterConfig']['consumer_secret'];
    $accessToken = $c['twitterConfig']['access_token'];
    $accessTokenSecret = $c['twitterConfig']['access_token_secret'];
    return new Abraham\TwitterOAuth\TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
};

$container['twitterConfig'] = function($c) {
    return parse_ini_file(__DIR__ . "/../conf/twitter.ini");
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

$container['articleRepo'] = $container->factory(function($c) {
    return new sat8bit\Matomepp\Article\ArticleRepository($c['pdo']);
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
