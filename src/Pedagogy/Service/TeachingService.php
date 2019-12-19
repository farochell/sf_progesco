<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   22/11/2019
 * @time  :   17:12
 */

namespace App\Pedagogy\Service;


use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Pedagogy\Entity\Teaching;

/**
 * Class TeachingService
 *
 * @package App\Pedagogy\Service
 *
 */
class TeachingService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton("Ajouter une matière", "fa fa-plus", "white-text text-lighten-4 light-green darken-4");
        $button->setUrl("teaching_add");
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [
            'Code',
            'Libellé',
            'Spécialité',
            '',
            '',
        ];
        $table   = $this->getTable("teaching");
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Teaching::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("code", $record->getCode()));
                $row->addCells($this->getCell("label", $record->getLabel()));
                $row->addCells($this->getCell("speciality", $record->getSpeciality()));
                
                $cell       = $this->getCell("upd", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", "Modifier", "teaching_upd", "light-blue darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell("del", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "teaching_del", "red darken-3 white-text"));
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