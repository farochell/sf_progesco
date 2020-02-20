<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   26/12/2019
 * @time  :   13:20
 */

namespace App\Accounting\Service;


use App\Accounting\Entity\Tuition;
use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;

/**
 * Class TuitionService
 *
 * @package App\Accounting\Service
 *
 */
class TuitionService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton($this->getTranslator()->trans('Ajouter des frais de scolarité'), 'fa fa-plus', 'white-text text-lighten-4 indigo lighten-1');
        $button->setUrl('tuition_add');
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [
            $this->getTranslator()->trans('Montant'),
            $this->getTranslator()->trans('Niveau'),
            $this->getTranslator()->trans('Filières'),
            $this->getTranslator()->trans('Année scolaire'),
            '',
        ];
        $table   = $this->getTable('tuition');
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Tuition::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('fees', $record->getFees(), '',
                    'money'));
                $row->addCells($this->getCell('level', $record->getLevel()));
                $row->addCells($this->getCell('studies', $this->splitStudies($record->getStudies())));
                $row->addCells($this->getCell('schoolyear', $record->getSchoolYear()));
                
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 'tuition_del', 'red darken-3 white-text'));
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
     * @param $studies
     *
     * @return string
     */
    public function splitStudies($studies) {
        $tab = [];
        foreach($studies as $study) {
            $tab [] = $study->getLabel();
        }
        
        return implode(',', $tab);
    }
}