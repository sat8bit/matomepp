<?php

namespace sat8bit\Matomepp\Recommendation;

class Recommendation
{
    /**
     * @var string
     */
    protected $keyword;

    /**
     * @param string $keyword
     */
    public function __construct($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }
}
