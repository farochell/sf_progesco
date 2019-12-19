<?php

namespace App\IHM\Model\Button;

/**
 * Interface FabriqueButton
 * @package App\IHM\Model\Button
 */
interface FabriqueButton
{
    /**
     * @param string $label
     * @param string $icon
     * @param string $class
     * @param string $id
     * @return mixed
     */
    public function createButton(string $label, string $icon,  string $class = "", string $id = "");
}