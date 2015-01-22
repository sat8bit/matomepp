<?php

namespace sat8bit\Matomepp\RSS;

use PDO;

class RSSRepository
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
     * @param RSS
     */
    public function store(RSS $rss)
    {
        $blogId = $this->insertBlog(array(
            'title' => $rss->channel->title,
            'index_url' => $rss->channel->link,
            'rss_url' => $rss->getUrl()
        ));

        foreach ($rss->item as $item) {
            $this->insertArticle(array(
               'url' => $item->link,
               'title' => $item->title,
               'description' => $item->description,
               'date' => $item->children('dc', true)->date,
               'blog_id' => $blogId
            ));
        }
    }

    protected function insertBlog(array $params)
    {
        $stmt = $this->pdo->prepare("
            SELECT
                blog_id
            FROM
                blogs
            WHERE
                index_url = :index_url
        ");

        $stmt->bindValue(':index_url', $params['index_url'], PDO::PARAM_STR);
        $stmt->execute();

        $blogId = null;
        if ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $blogId = $record['blog_id'];
        }
        
        $stmt = $this->pdo->prepare("
            INSERT INTO blogs(
                title
              , index_url
              , rss_url
            )
            VALUES(
                :title
              , :index_url
              , :rss_url
            )
            ON DUPLICATE KEY UPDATE
                title = :title
        ");

        $stmt->bindValue(':title', $params['title'], PDO::PARAM_STR);
        $stmt->bindValue(':index_url', $params['index_url'], PDO::PARAM_STR);
        $stmt->bindValue(':rss_url', $params['rss_url'], PDO::PARAM_STR);

        $stmt->execute();

        return $blogId ?: $this->pdo->lastInsertId();
    }

    protected function insertArticle(array $params)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO articles(
                url
              , title
              , description
              , date
              , blog_id
            )
            VALUES(
                :url
              , :title
              , :description
              , :date
              , :blog_id
            )
            ON DUPLICATE KEY UPDATE
                title = :title
              , description = :description
              , date = :date
              , blog_id = :blog_id
        ");

        $stmt->bindValue(':url', $params['url'], PDO::PARAM_STR);
        $stmt->bindValue(':title', $params['title'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $params['description'], PDO::PARAM_STR);
        $stmt->bindValue(':date', $params['date'], PDO::PARAM_STR);
        $stmt->bindValue(':blog_id', $params['blog_id'], PDO::PARAM_INT);

        $stmt->execute();
    }
}
