<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/02/2020
 * @time  :   11:27
 */

namespace App\Scoring\Service;


use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Scoring\Entity\TypeOfRating;

/**
 * Class TypeOfRatingService
 *
 * @package App\Scoring\Service
 *
 */
class TypeOfRatingService extends ManagerService {
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton($this->getTranslator()->trans("Ajouter un type de devoir"), "fa fa-plus", "white-text text-lighten-4 light-green darken-4");
        $button->setUrl("typeofrating_add");
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [
            $this->getTranslator()->trans('Libellé'),
            '',
            '',
        ];
        $table   = $this->getTable("typeoftypeofrating");
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(TypeOfRating::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("label", $record->getLabel()));
                
                $cell       = $this->getCell("upd", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", $this->getTranslator()->trans("Modifier"), "typeofrating_upd", "light-blue darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell("del", "", "cell-action");
                $cellAction = $this->getCellAction("upd", "link");
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", $this->getTranslator()->trans("Supprimer"),
                    "typeofrating_del", "red darken-3 white-text"));
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