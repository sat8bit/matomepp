<?php

namespace sat8bit\Matomepp\Service;

use Abraham\TwitterOAuth\TwitterOAuth;
use sat8bit\Matomepp\Article\Article;

class PickupTweetService
{
    /**
     * @var TwitterOAuth
     */
    protected $twitter;

    /**
     * @param array $config
     */
    public function __construct(TwitterOAuth $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @param Article $article
     */
    public function provide(Article $article)
    {
        $this->twitter->post("statuses/update", array(
            "status"=> "{$article->getTitle()} - http://matomepp.net/pickup/{$article->getArticleId()}"
        ));
        echo $this->twitter->getLastHttpCode();
        var_dump($this->twitter->getLastBody());
    }
}
