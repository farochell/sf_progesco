<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   27/12/2019
 * @time  :   14:16
 */

namespace App\Student\Service;


use App\Etudiant\Entity\Etudiant;
use App\IHM\Model\Button\FabriqueButtonLink;
use App\Manager\Service\ManagerService;
use App\Student\Entity\Student;

/**
 * Class StudentService
 *
 * @package App\Student\Service
 * 
 */
class StudentService extends ManagerService
{
    /**
     * @return array
     */
    public function addButton()
    {
        $fabrique = new FabriqueButtonLink();
        $button   =
            $fabrique->createButton($this->getTranslator()->trans("Ajouter un(e) étudiant(e)"), "fa fa-plus", "white-text btn-secondary");
        $button->setUrl("student_add");
        $this->setButtons($button);
        
        return $this->getButtons();
    }
    
    /**
     * @return array
     */
    public function findAll()
    {
        $headers = [
            $this->getTranslator()->trans('Matricule'),
            $this->getTranslator()->trans('Prénom'),
            $this->getTranslator()->trans('Nom'),
            '',
            '',
            '',
        ];
        $table   = $this->getTable("student");
        $table->addHeaders($headers);
        // initialize a query builder
        $filterBuilder = $this->getContainer()
                              ->get('doctrine.orm.entity_manager')
                              ->getRepository(Student::class)
                              ->createQueryBuilder('e');
    
        /*$form = $this->getContainer()
                     ->get('form.factory')
                     ->create(RechercheEtudiantType::class);
    
        if ($this->getRequest()->query->has($form->getName())) {
            // manually bind values from the request
            $form->submit($this->getRequest()->query->get($form->getName()));
        
            // build the query from the given form object
            $this->getContainer()
                 ->get('lexik_form_filter.query_builder_updater')
                 ->addFilterConditions($form, $filterBuilder);
        }*/
    
        $query = $filterBuilder->getQuery();
    
        $paginator = $this->getContainer()
                          ->get('knp_paginator');
    
        //$paginator = $this->getPaginator();
        $pagination = $paginator->paginate($query, /* query NOT result */
            $this->getRequest()->query->getInt('page', 1)/*page number*/,
            self::PER_PAGE/*limit per page*/
        );
    
        if ($pagination) {
            foreach ($pagination as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("matricule", $record->getMatricule()));
                $row->addCells($this->getCell("lastname", $record->getLastname()));
                $row->addCells($this->getCell("firstname", $record->getFirstname()));
            
                // Set action cell
                $cell       = $this->getCell("action", "", "cell-action");
                $cellAction = $this->getCellAction("edit", "link");
                // Add attribute
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-edit", $this->getTranslator()->trans("Modifier"), "student_upd", "light-blue darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
                // Set info cell
                $cell       = $this->getCell("action", "", "cell-action");
                $cellAction = $this->getCellAction("detail", "link");
                // Detail attribute
                $cellAction->setCellattribute($this->getCellAttribute("fas fa-eye", $this->getTranslator()->trans("Détail"), "student_edit", "grey darken-3 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
            
                // Set delete cell
                $cell       = $this->getCell("action", "", "cell-action");
                $cellAction = $this->getCellAction("delete", "ajax");
                // Dell attribute
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", $this->getTranslator()->trans("Supprimer"), "student_del", "bg-danger white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
            
                $table->addRows($row);
            }
        }
        return [
            'table'      => $table,
            'pagination' => $pagination,
            /*'form'       => $form->createView(),*/
        ];
    }
    
    /**
     * @return mixed
     * @throws \Exception
     */
    public function find()
    {
        $request = $this->getRequest();
        $id      = $request->get('id');
        $record  = $this->getEm()
                        ->getRepository(Student::class)
                        ->find($id);
        if (!$record) {
            throw new \Exception('Etudiant non trouvé');
        }
        
        return $record;
    }
}