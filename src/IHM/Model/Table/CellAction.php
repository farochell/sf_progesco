<?php

namespace App\IHM\Model\Table;

class CellAction
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var
     */
    private $cellattribute;

    /**
     * CellAction constructor.
     * @param string $name
     * @param string $type
     */
    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCellattribute()
    {
        return $this->cellattribute;
    }


    /**
     * @param CellAttribute $cellattribute
     */
    public function setCellattribute(CellAttribute $cellattribute)
    {
        $this->cellattribute = $cellattribute;
    }

}