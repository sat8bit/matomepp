<?php

namespace sat8bit\Matomepp\Service;

use Abraham\TwitterOAuth\TwitterOAuth;
use sat8bit\Matomepp\Article\Article;
use PDO;

class PickupTweetService
{
    /**
     * @var TwitterOAuth
     */
    protected $twitter;

    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @param array $config
     */
    public function __construct(TwitterOAuth $twitter, PDO $pdo)
    {
        $this->twitter = $twitter;
        $this->pdo = $pdo;
    }

    /**
     * @param Article $article
     */
    public function provide(Article $article)
    {
        $this->twitter->post("statuses/update", array(
            "status"=> "{$article->getTitle()} >> http://matomepp.net/pickup/{$article->getArticleId()}"
        ));

        if ($this->twitter->getLastHttpCode() != 200) {
            throw new \RuntimeException(json_encode($this->twitter->getLastBody()));
        }

        $this->storeTweets($article);
    }

    /**
     * @param Article $article
     */
    protected function storeTweets(Article $article)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO tweets (
                article_id
            )
            VALUES (
                :article_id
            )
        ");

        $stmt->bindValue(':article_id', $article->getArticleId(), PDO::PARAM_INT);
        $stmt->execute();
    }
}
