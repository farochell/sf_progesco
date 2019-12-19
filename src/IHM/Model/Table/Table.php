<?php

namespace App\IHM\Model\Table;

/**
 * Class Table
 * @package App\IHM\Model\Table
 */
class Table
{
    /**
     * @var
     */
    private $id;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $rows = [];

    /**
     * Table constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;

    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function addHeaders($headers)
    {
        $this->headers[] = $headers;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param mixed $rows
     */
    public function addRows($rows)
    {
        $this->rows[] = $rows;
    }

}