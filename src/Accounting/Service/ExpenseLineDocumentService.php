<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   15/02/2020
 */

namespace App\Accounting\Service;


use App\Accounting\Entity\ExpenseLineDocument;
use App\Manager\Service\ManagerService;
use App\Manager\Util\Constant;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ExpenseLineDocumentService
 *
 * @package App\Accounting\Service
 *
 */
class ExpenseLineDocumentService extends ManagerService {
    
    /**
     * @param FormInterface $form
     * @param               $entity
     * @param JsonResponse  $response
     *
     * @return JsonResponse
     */
    public function add(FormInterface $form, $entity, JsonResponse $response) {
        $expenseLineFileUploader = new ExpenseLineFileUploader($this->getContainer()->getParameter('expense_line_document_upload_destination'));
        $em = $this->getEm();
        $em->getConnection()->beginTransaction();
        $entity = $form->getData();
        try {
            $thumbnailFile = $form['thumbnail']->getData();
            if ($thumbnailFile) {
                $thumbnailFileName = $expenseLineFileUploader->upload($thumbnailFile);
                $entity->setThumbnailName($thumbnailFileName);
            }
            $em->persist($entity);
            $em->flush();
            $em->getConnection()->commit();
            $this->getRequest()->getSession()->getFlashBag()->add(
                'notice',
                'Enregistrement effectué !'
            );
            $response->setData(
                [
                    Constant::FLASH_STATUS_LABEL => 'OK',
                    Constant::FLASH_MSG_LABEL    => 'Enregistrement effectué avec succès',
                ]
            );
        } catch (\Exception $e) {
            // Rollback the failed transaction attempt
            $em->getConnection()->rollback();
            $this->getRequest()->getSession()->getFlashBag()->add(
                'danger',
                'Une erreur est intervenue: '.$e->getMessage()
            );
            $response->setData(
                [
                    Constant::FLASH_STATUS_LABEL => 'NOK',
                    Constant::FLASH_MSG_LABEL    => 'Une erreur est intervenue !'.$e->getMessage(),
                ]
            );
            
            return $response;
            
        }
        
        return $response;
    }
    
    public function findDocumentsByExpense($params) {
        $headers = ['Libellé', 'Commentaire', '', ''];
        $table = $this->getTable("instancedepensedocument");
        $table->addHeaders($headers);
    
        $records = $this->getEm()->getRepository(ExpenseLineDocument::class)->findByExpenseLine($params['expense_line_id']);
        if($records) {
            foreach ($records as $record) {
                $row = $this->getRow($record->getId());
                $row->addCells($this->getCell("libelle", $record->getLabel()));
                $row->addCells($this->getCell("commentaire", $record->getComment()));
                // Set action cell
                $cell = $this->getCell("action");
                $cellAction = $this->getCellAction("edit", "link");
                // Add attribute
                $cellAction->setCellattribute($this->getCellAttribute("fas fa-download", "Télécharger", "", "indigo accent-4 white-text"));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
            
                // Set action cell
                $cell = $this->getCell("action");
                $cellAction = $this->getCellAction("delete", "link");
                // Add attribute
                $params = ['id' => $record->getId(),'expense_line_id' => $record->getExpenseLine()->getId()];
                $cellAction->setCellattribute($this->getCellAttribute("fa fa-trash", "Supprimer", "", "bg-danger white-text","",$params));
                $cell->setCellAction($cellAction);
                $row->addCells($cell);
            
                $table->addRows($row);
            }
        }
    
        return ['table' => $table, 'pagination' => null];
    }
}