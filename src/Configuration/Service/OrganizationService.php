<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   14/01/2020
 * @time  :   11:20
 */

namespace App\Configuration\Service;


use App\Configuration\Entity\Organization;
use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;

/**
 * Class OrganizationService
 *
 * @package App\Configuration\Service
 * 
 */
class OrganizationService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton($this->getTranslator()->trans('Ajouter un établissement'), 'fa fa-plus', 'white-text text-lighten-4 light-green darken-4');
        $button->setUrl('organization_add');
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [
            $this->getTranslator()->trans('Nom'),
            '',
            '',
        ];
        $table   = $this->getTable('organization');
        $table->addHeaders($headers);
        $records = $this->getEm()
                        ->getRepository(Organization::class)
                        ->findAll();
        
        if ($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell('name', $record->getName()));
                
                $cell       = $this->getCell('upd', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-edit', $this->getTranslator()->trans('Modifier'), 'organization_upd', 'light-blue darken-3 white-text'));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                
                $cell       = $this->getCell('del', '', 'cell-action');
                $cellAction = $this->getCellAction('upd', 'link');
                $cellAction->setCellattribute($this->getCellAttribute('fa fa-trash', $this->getTranslator()->trans('Supprimer'), 
                    'organization_del', 'red darken-3 white-text'));
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
    public function find ()
    {
        $record = $this->getEm ()->getRepository ( Organization::class )->find ( 1 );
        if ( !$record ) {
            throw new \Exception( 'Etablissement non trouvé' );
        }
        
        
        return $record;
    }
}