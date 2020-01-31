<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   14/01/2020
 * @time  :   23:16
 */

namespace App\Accounting\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class ExpenseTypeRepository
 *
 * @package App\Accounting\Repository
 *
 */
class ExpenseTypeRepository extends EntityRepository
{
    /**
     * ExpenseTypeRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
}