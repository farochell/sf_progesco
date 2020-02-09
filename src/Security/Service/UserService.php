<?php

namespace App\Security\Service;

use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Security\Entity\User;
use CommonBundle\Model\Table\Table;

/**
 * Class UserService
 *
 * @package App\Security\Service
 *
 */
class UserService extends ManagerService {
    /**
     *
     * {@inheritDoc}
     * @see \App\manager\services\ManagerService::getButtons()
     */
    public function addButton() {
        $fabrique = new FabriqueButtonLink();
        $button   = $fabrique->createButton(
            $this->getTranslator()->trans("Ajouter un utilisateur"), "fa fa-plus", "white-text text-lighten-4 blue-grey darken-1"
        );
        $button->setUrl("user_add");
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return Table
     */
    public function findAll() {
        $headers = [
            $this->getTranslator()->trans('Identifiant'),
            $this->getTranslator()->trans('Nom'),
            $this->getTranslator()->trans('Prénom'),
            '',
            '',
            '',
        ];
        $table   = $this->getTable("uer");
        $table->addHeaders($headers);
        $records = $this->getEm()->getRepository(User::class)->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("username", $record->getUsername()));
                $row->addCells($this->getCell("lastName", $record->getLastName()));
                $row->addCells($this->getCell("firstName", $record->getFirstName()));
                
                // Set action cell
                $cell       = $this->getCell("action");
                $cellAction = $this->getCellAction("upd", "link");
                // Add attribute
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", $this->getTranslator()->trans("Modifier"), "user_upd"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                // Set action cell
                $cell       = $this->getCell("action");
                $cellAction = $this->getCellAction("edit", "link");
                // Add attribute
                $cellAction->setCellattribute($this->getCellAttribute("fas fa-eye", $this->getTranslator()->trans("Editer"), "user_edit", "grey darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                
                // Set delete cell
                $cell       = $this->getCell("action");
                $cellAction = $this->getCellAction("delete", "ajax");
                // Dell attribute
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", $this->getTranslator()->trans("Supprimer"), "", "bg-danger", "deleteProfesseur"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $table->addRows($row);
            }
        }
        
        return [
            'table'      => $table,
            'pagination' => null,
        ];
    }
    
    /**
     * Find student by id
     * @return unknown
     * @throws \Exception
     */
    public function find() {
        $request = $this->getRequest();
        $id      = $request->get('id');
        $record  = $this->getEm()->getRepository(User::class)->find($id);
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
    public function listUserRoles() {
        $headers = [
            $this->getTranslator()->trans('Libellé'),
            $this->getTranslator()->trans('Description'),
            '',
        ];
        $table   = $this->getTable("role_user");
        $table->addHeaders($headers);
        $user    = $this->getEm()->getRepository(User::class)->find($this->getRequest()->get('id'));
        $records = $user->getRolesObject();
        
        if ($records) {
            
            foreach ($records as $record) {
                
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("libelle", $record->getLabel()));
                $row->addCells($this->getCell("description", $record->getDescription()));
                
                // Set action cell
                $cell       = $this->getCell("action");
                $cellAction = $this->getCellAction("del", "link");
                // Add attribute
                $params = ['role_id' => $record->getId(), 'user_id' => $user->getId()];
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", $this->getTranslator()->trans("Supprimer"), "user_role_del", "bg-danger", "", $params));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $table->addRows($row);
            }
        }
        
        return [
            'table'      => $table,
            'pagination' => null,
        ];
    }
}