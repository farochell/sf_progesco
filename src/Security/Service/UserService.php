<?php

namespace App\Security\Service;

use App\Security\Entity\User;
use App\Manager\Service\ManagerService;
use App\IHM\Model\Button\FabriqueButtonLink;

class UserService extends ManagerService
{
    /**
     *
     * {@inheritDoc}
     * @see \App\manager\services\ManagerService::getButtons()
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button = $fabrique->createButton("Ajouter un utilisateur", "fa fa-plus", "white-text text-lighten-4 blue-grey darken-1");
        $button->setUrl("user_add");
        $this->setButtons($button);
        return $this->getButtons();
    }

    /**
     * @return \CommonBundle\Model\Table\Table
     */
    public function findAll()
    {
        $headers = [  
            'Identifiant',
            'Nom',
            'Prénom', 
            '', 
            '',          
            ''
        ];
        $table = $this->getTable("uer");
        $table->addHeaders($headers);
        $records = $this->getEm()->getRepository(User::class)->findAll();

        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());  
                $row->addCells($this->getCell("username", $record->getUsername()));        
                $row->addCells($this->getCell("lastName", $record->getLastName()));
                $row->addCells($this->getCell("firstName", $record->getFirstName()));

                // Set action cell
                $cell = $this->getCell("action");
                $cellAction = $this->getCellAction("upd", "link");
                // Add attribute
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Editer", "user_upd"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);

                // Set action cell
                $cell = $this->getCell("action");
                $cellAction = $this->getCellAction("edit", "link");
                // Add attribute
                $cellAction->setCellattribute($this->getCellAttribute("fas fa-eye", "Editer", "user_edit", "grey darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
           

                // Set delete cell
                $cell = $this->getCell("action");
                $cellAction = $this->getCellAction("delete", "ajax");
                // Dell attribute
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "", "bg-danger", "deleteProfesseur"));
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

    /**
     * Find student by id
     * @throws \Exception
     * @return unknown
     */
    public function find()
    {
        $request = $this->getRequest();
        $id = $request->get('id');              
        $record = $this->getEm()->getRepository(User::class)->find($id);
        if (!$record) {
            throw new \Exception('Enregistrement non trouvé');
        }
        
        
        return $record;
    }

    /**
     * listUserRoles function
     *
     * @return void
     */
    public function listUserRoles(){
        $headers = [  
            'Libellé', 
            'Description',                 
            ''
        ];
        $table = $this->getTable("role_user");
        $table->addHeaders($headers);
        $user = $this->getEm()->getRepository(User::class)->find($this->getRequest()->get('id'));
        $records = $user->getRolesObject();
       
        if ($records) {
            
            foreach ($records as $record) {
             
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("libelle", $record->getLabel()));
                $row->addCells($this->getCell("description", $record->getDescription())); 

                // Set action cell
                $cell = $this->getCell("action");
                $cellAction = $this->getCellAction("del", "link");
                // Add attribute
                $params = ['role_id' => $record->getId(), 'user_id' => $user->getId()];
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "user_role_del", "bg-danger","",$params));
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