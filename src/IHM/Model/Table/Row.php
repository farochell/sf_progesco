<?php

namespace App\IHM\Model\Table;

/**
 * Class Row
 * @package App\IHM\Model\Table
 */
class Row
{
    /**
     * @var
     */
    private $id;
    /**
     * @var array
     */
    private $cells = [];

    /**
     * Row constructor.
     * @param $id
     * @param Cell[] ...$cells
     */
    public function __construct($id, Cell ...$cells)
    {
        $this->id = $id;
        $this->cells = $cells;
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
     * @return array
     */
    public function getCells()
    {
        return $this->cells;
    }


    /**
     * @param Cell $cells
     */
    public function addCells(Cell $cells)
    {
        $this->cells[] = $cells;
    }

}