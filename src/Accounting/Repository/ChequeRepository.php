<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   17:55
 */

namespace App\Accounting\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class ChequeRepository
 *
 * @package App\Accounting\Repository
 *
 */
class ChequeRepository extends EntityRepository
{
    /**
     * ChequeRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
}