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
        $this->xml = simplexml_load_file($url, null, LIBXML_NSCLEAN);
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
}
