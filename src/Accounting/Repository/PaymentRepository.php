<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   24/12/2019
 * @time  :   15:24
 */

namespace App\Accounting\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class PaymentRepository
 *
 * @package App\Accounting\Repository
 *
 */
class PaymentRepository extends EntityRepository
{
    /**
     * PaymentRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
    
    /**
     * @param int $year
     *
     * @return mixed
     */
    public function getOpenPayements (int $year)
    {
        return $this->getEntityManager()
                    ->createQuery(
                        'SELECT p FROM App\Accounting\Entity\Payment p
                          JOIN p.registration i
                          WITH i.schoolYear = :year
                          WHERE p.balance != 0 AND p.status = 1 ORDER BY p.created DESC')
                    ->setParameter('year', $year)
                    ->getResult();
    }
    
    /**
     * @param int $year
     *
     * @return mixed
     */
    public function getClosedPayments (int $year)
    {
        return $this->getEntityManager()
                    ->createQuery(
                        'SELECT p FROM App\Accounting\Entity\Payment p
                          JOIN p.registration i
                          WITH i.schoolYear = :year
                          WHERE p.balance = 0 AND p.status = 1 ORDER BY p.created DESC')
                    ->setParameter('year', $year)
                    ->getResult();
    }
}