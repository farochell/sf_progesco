<?php
/*
 * Created on Sat Mar 31 2018
 *
 * Author: Emile Camara <camara.emile@gmail.com>
 */

namespace App\Security\Service;

use App\Security\Entity\Role;
use App\Manager\Service\ManagerService;
use App\IHM\Model\Button\FabriqueButtonLink;

/**
 * Class RoleService
 *
 * @package App\Security\Service
 */
class RoleService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =  $fabrique->createButton("Ajouter un rôle", "fa fa-plus", "white-text text-lighten-4 light-green darken-4");
        $button->setUrl("role_add");
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [  
            'Libellé',                    
            'Description',
            'Menu',
            '',                    
            ''
        ];
        $table = $this->getTable("role");
        $table->addHeaders($headers);
        $records = $this->getEm()->getRepository(Role::class)->findAll();

        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());  
                $row->addCells($this->getCell("label", $record->getLabel()));
                $row->addCells($this->getCell("description", $record->getDescription()));
                $row->addCells($this->getCell("menu", $record->getMenu()));

                // Set action cell
                $cell = $this->getCell("action");
                $cellAction = $this->getCellAction("edit", "link");
                // Add attribute
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Editer", "role_upd"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);

           

                // Set delete cell
                $cell = $this->getCell("action");
                $cellAction = $this->getCellAction("delete", "link");
                // Dell attribute
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "role_del", "bg-danger"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);

                $table->addRows($row);
            }
        }

        return [
            'table' => $table,
            'pagination' => null
        ];
    }
}