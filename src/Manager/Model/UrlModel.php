<?php

namespace App\Manager\Model;

/**
 * UrlModel class
 */
class UrlModel
{
    /**
     *
     * @var string
     */
    private $url;

    /**
     *
     * @var array
     */
    private $params=[];

    public function __construct(string $url, array $params=[]){
        $this->url = $url;
        $this->params = $params;
    }
    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }
}