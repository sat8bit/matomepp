<?php

namespace sat8bit\Matomepp\Blog;

class Blog
{
    /**
     * @var int
     */
    protected $blogId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $indexUrl;

    /**
     * @var string
     */
    protected $rssUrl;

    /**
     * @param int $blogId
     */
    public function __construct($blogId)
    {
        $this->blogId = $blogId;
    }

    /**
     * @return int
     */
    public function getBlogId()
    {
        return $this->blogId;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $indexUrl
     */
    public function setIndexUrl($indexUrl)
    {
        $this->indexUrl = $indexUrl;
    }

    /**
     * @return string
     */
    public function getIndexUrl()
    {
        return $this->indexUrl;
    }

    /**
     * @param string $rssUrl
     */
    public function setRssUrl($rssUrl)
    {
        $this->rssUrl = $rssUrl;
    }

    /**
     * @return string
     */
    public function getRssUrl()
    {
        return $this->rssUrl;
    }
}
