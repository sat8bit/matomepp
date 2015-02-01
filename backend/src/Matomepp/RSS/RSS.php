<?php

namespace sat8bit\Matomepp\RSS;

class RSS
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var SimpleXML
     */
    protected $xml;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->xml = @simplexml_load_file($url, null, LIBXML_NSCLEAN);

        if (!$this->isRss()) {
            throw new \InvalidArgumentException("input url is not rss . url:$url");
        }
    }

    public function __get($key)
    {
        return $this->xml->$key;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return boolean
     */
    protected function isRss()
    {
        if (empty($this->xml->channel)) {
            return false;
        }

        if (empty($this->xml->channel->title)) {
            return false;
        }

        if (empty($this->xml->channel->link)) {
            return false;
        }

        if (empty($this->xml->item)) {
            return false;
        }

        foreach ($this->xml->item as $item) {
            if(empty($item->link)) {
                return false;
            }

            if(empty($item->title)) {
                return false;
            }

            if(empty($item->children('dc', true)->date)) {
                return false;
            }
        }

        return true;
    }
}
