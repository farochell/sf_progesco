<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   15:18
 */

namespace App\Accounting\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class ScholarshipPaymentPlanRepository
 *
 * @package App\Accounting\Repository
 *
 */
class ScholarshipPaymentPlanRepository extends EntityRepository
{
    /**
     * ScholarshipPaymentPlanRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
}