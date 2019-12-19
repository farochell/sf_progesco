<?php

namespace App\IHM\Model\Table;

/**
 * Class CellAttribute
 * @package App\IHM\Model\Table
 */
class CellAttribute
{
    /**
     * @var
     */
    private $icon;
    /**
     * @var
     */
    private $color;

    /**
     * @var
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $ajax;

    /**
     * @type
     */
    private $params;

    /**
     * CellAttribute constructor.
     *
     * @param $icon
     * @param $title
     * @param $color
     * @param $params
     */
    public function __construct(string $icon, string $title, string $url = NULL, string $color, array $params = [])
    {
        $this->icon = $icon;
        $this->title = $title;
        $this->url = $url;
        $this->color = $color;
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getAjax()
    {
        return $this->ajax;
    }

    /**
     * @param mixed $ajax
     */
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

}