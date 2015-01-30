<?php

namespace sat8bit\Matomepp\Article;

use PDO;

class ArticleRepository
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param int $articleId
     * @return array
     */
    public function findByArticleId($articleId)
    {
        $stmt = $this->pdo->prepare("
            SELECT
                article_id
              , title
              , url
            FROM
                articles
            WHERE
                article_id = :article_id
        ");

        $stmt->bindValue(':article_id', $articleId, PDO::PARAM_INT);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($record)) {
            return null;
        }

        $article = new Article($record['article_id']);
        $article->setTitle($record['title']);
        $article->setUrl($record['url']);

        return $article;
    }
}
