<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   11/12/2019
 * @time  :   14:39
 */

namespace App\Teacher\Service;


use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Teacher\Entity\Teacher;

/**
 * Class TeacherService
 *
 * @package App\Teacher\Service
 *
 */
class TeacherService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton("Ajouter un professeur", "fa fa-plus", "white-text text-lighten-4 light-green darken-4");
        $button->setUrl("teacher_add");
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [
            'Prénom',
            'Nom',
            'Matricule',
            'Téléphone',
            '',
            '',
            '',
        ];
        $table   = $this->getTable("teacher");
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Teacher::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("firstname", $record->getFirstname()));
                $row->addCells($this->getCell("lastname", $record->getLastname()));
                $row->addCells($this->getCell("matricule", $record->getMatricule()));
                $row->addCells($this->getCell("phone1", $record->getPhone1(). "/" . $record->getPhone2()));
                
                $cell       = $this->getCell("upd", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Modifier", "teacher_upd", "light-blue darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell("del", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fas fa-eye", "Editer", "teacher_edit", "grey darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell("del", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "teacher_del", "red darken-3 white-text"));
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
     * @return mixed
     * @throws \Exception
     */
    public function find()
    {
        $request = $this->getRequest();
        $id = $request->get('id');
        
        $record = $this->getEm()->getRepository(Teacher::class)->find($id);
        if (!$record) {
            throw new \Exception('Teacher with ID:' . $id . ' not found');
        }
        
        return $record;
    }
}