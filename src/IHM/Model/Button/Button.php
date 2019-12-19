<?php

namespace App\IHM\Model\Button;

/**
 * Class Button
 * @package App\IHM\Model\Button
 */
abstract class Button
{
    /**
     * Nom de la classe
     *
     * @var string
     */
    protected $class;

    /**
     * Nom de l'icone
     *
     * @var string
     */
    protected $icon;

    /**
     * LibellÃ© du label
     *
     * @var string
     */
    protected $label;

    /**
     * Nom de l'id
     *
     * @var string
     */
    protected $id;

    /**
     * Type de bouton
     *
     * @var string
     */
    protected $type;

    /**
     * @param string $label
     * @param string $icon
     * @param string $type
     * @param string $class
     * @param string $id
     */
    public function __construct(string $label, string $icon, string $type, string $class = "", string $id = "")
    {
        $this->label = $label;
        $this->icon = $icon;
        $this->type = $type;
        $this->class = $class;
        $this->id = $id;
    }
}