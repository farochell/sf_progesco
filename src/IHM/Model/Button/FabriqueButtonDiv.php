<?php

namespace App\IHM\Model\Button;

/**
 * Class FabriqueButtonDiv
 * @package App\IHM\Model\Button
 */
class FabriqueButtonDiv implements FabriqueButton
{
    /**
     * @param string $label
     * @param string $icon
     * @param string $class
     * @param string $id
     * @return ButtonDiv
     */
    public function createButton(string $label, string $icon,  string $class = "", string $id = ""){
        return new ButtonDiv($label,$icon,$class,$id);
    }
}