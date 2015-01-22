<?php

namespace sat8bit\Matomepp\Blog;

use PDO;

class BlogRepository
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
     * @return array
     */
    public function findAll()
    {
        $stmt = $this->pdo->prepare("
            SELECT
                blog_id
              , title
              , index_url
              , rss_url
            FROM
                blogs
        ");

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = array();

        foreach($stmt as $record) {
            $blog = new Blog($record['blog_id']);
            $blog->setTitle($record['title']);
            $blog->setIndexUrl($record['index_url']);
            $blog->setRssUrl($record['rss_url']);
            $result[] = $blog;
        }

        return $result;
    }
}
