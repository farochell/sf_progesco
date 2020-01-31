<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   23/01/2020
 * @time  :   14:13
 */

namespace App\Accounting\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class ExpenseLineDocumentRepository
 *
 * @package App\Accounting\Repository
 *
 */
class ExpenseLineDocumentRepository extends EntityRepository {
    /**
     * ExpenseLineDocumentRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
}