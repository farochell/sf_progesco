<?php

namespace App\IHM\Model\Table;

/**
 * Class Cell
 * @package App\IHM\Model\Table
 */
class Cell
{
    /**
     * Variable indiquant le nom de la cellule
     * @var string
     */
    private $name = null;

    /**
     * Variable indiquant la valeur de la cellule
     * @var string
     */
    private $value = null;

    /**
     * Variable indiquant le type d'action a appliquer à la cellule
     * @var string
     */
    private $cellAction = null;

    /**
     * Variable indiquant le type de la cellule (chaine de caractère, date,
     * numérique, monétaire...)
     * @var string
     */
    private $type = null;

    /**
     * Variable indiquant le nom de la classe css à appliquer
     * @var string
     */
    private $className = null;

    /**
     *
     * @param string $name
     * @param string $value
     * @param string $className
     * @param string $type
     */
    public function __construct(string $name,  $value , string $className = null, string $type = "string")
    {
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        $this->className = $className;
    }

    /**
     *
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     *
     * @return string
     */
    public function getCellAction()
    {
        return $this->cellAction;
    }

    /**
     *
     * @return string
     */
    public function getType():string
    {
        return $this->type;
    }

    /**
     *
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     *
     * @param string $cellAction
     */
    public function setCellAction($cellAction)
    {
        $this->cellAction = $cellAction;
    }

    /**
     *
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     *
     * @return string
     */
    public function getClassName():string
    {
        return $this->className;
    }

    /**
     *
     * @param string $className
     */
    public function setClassName(string $className)
    {
        $this->className = $className;
    }
}
