<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   25/11/2019
 * @time  :   11:21
 */

namespace App\Classroom\Service;


use App\Classroom\Entity\Classroom;
use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;

/**
 * Class ClassroomService
 *
 * @package App\Classroom\Service
 * 
 */
class ClassroomService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton("Ajouter une salle de classe", "fa fa-plus", "white-text text-lighten-4 light-green darken-4");
        $button->setUrl("classroom_add");
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
            '',
            '',
            '',
        ];
        $table   = $this->getTable("classroom");
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Classroom::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("label", $record->getLabel()));
                
                $cell       = $this->getCell("upd", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Modifier", "classroom_upd", "light-blue darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell("del", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fas fa-eye", "Editer", "classroom_edit", "grey darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell("del", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "classroom_del", "red darken-3 white-text"));
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
        
        $record = $this->getEm()->getRepository(Classroom::class)->find($id);
        if (!$record) {
            throw new \Exception('Classroom with ID:' . $id . ' not found');
        }
        
        return $record;
    }
}