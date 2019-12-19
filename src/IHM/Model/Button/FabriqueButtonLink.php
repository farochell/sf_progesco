<?php

namespace App\IHM\Model\Button;

/**
 * Class FabriqueButtonLink
 * @package App\IHM\Model\Button
 */
class FabriqueButtonLink implements FabriqueButton
{
    /**
     * @param string $label
     * @param string $icon
     * @param string $class
     * @param string $id
     * @return ButtonLink
     */
    public function createButton(string $label, string $icon, string $class = "", string $id = "")
    {

        return new ButtonLink($label, $icon, $class, $id);
    }
}
