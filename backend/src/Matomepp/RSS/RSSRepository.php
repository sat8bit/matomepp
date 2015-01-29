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
        $blogId = $this->selectBlogId($rss->getUrl());

        if (empty($blogId)) {
            $blogId = $this->insertBlog(array(
                'title' => $rss->channel->title,
                'index_url' => $rss->channel->link,
                'rss_url' => $rss->getUrl()
            ));
        }

        foreach ($rss->item as $item) {
            if ($this->selectArticle($item->link)) {
                break;
            }

            $this->insertArticle(array(
               'url' => $item->link,
               'title' => $item->title,
               'description' => $item->description,
               'date' => $item->children('dc', true)->date,
               'blog_id' => $blogId
            ));
        }
    }

    protected function selectBlogId($rssUrl)
    {
        $stmt = $this->pdo->prepare("
            SELECT
                blog_id
            FROM
                blogs
            WHERE
                rss_url = :rss_url
        ");

        $stmt->bindValue(':rss_url', $rssUrl, PDO::PARAM_STR);
        $stmt->execute();

        if ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $record['blog_id'];
        }

        return null;
    }

    protected function insertBlog(array $params)
    {
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
        ");

        $stmt->bindValue(':title', $params['title'], PDO::PARAM_STR);
        $stmt->bindValue(':index_url', $params['index_url'], PDO::PARAM_STR);
        $stmt->bindValue(':rss_url', $params['rss_url'], PDO::PARAM_STR);

        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    protected function selectArticle($url)
    {
        $stmt = $this->pdo->prepare("
            SELECT
                url
              , title
              , description
              , date
              , blog_id
            FROM
                articles
            WHERE
                url = :url
        ");

        $stmt->bindValue(':url', $url, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        ");

        $stmt->bindValue(':url', $params['url'], PDO::PARAM_STR);
        $stmt->bindValue(':title', $params['title'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $params['description'], PDO::PARAM_STR);
        $stmt->bindValue(':date', $params['date'], PDO::PARAM_STR);
        $stmt->bindValue(':blog_id', $params['blog_id'], PDO::PARAM_INT);

        $stmt->execute();
    }
}
