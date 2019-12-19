<?php

namespace App\IHM\Model\Button;

/**
 * Class ButtonDiv
 * @package App\IHM\Model\Button
 */
class ButtonDiv extends Button
{
    /**
     * @param string $label
     * @param string $icon
     * @param string $class
     * @param string $id
     */
    public function __construct(string $label, string $icon,  string $class = "", string $id = "")
    {
        parent::__construct($label, $icon, 'div', $class, $id);
    }
}