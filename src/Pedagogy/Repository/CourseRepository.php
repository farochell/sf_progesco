<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   28/11/2019
 * @time  :   15:51
 */

namespace App\Pedagogy\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class CourseRepository
 *
 * @package App\Pedagogy\Repository
 *
 */
class CourseRepository extends EntityRepository
{
    /**
     * CourseRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
    
    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param int       $groupId
     *
     * @return array
     */
    public function getCourseByGroupAndDate(\DateTime $startDate, \DateTime $endDate, int $groupId) {
       
        $qb = $this->getEntityManager()->createQueryBuilder();
    
        return $qb
            ->select('e, te, g, c')
            ->from('App\\Pedagogy\\Entity\\Course', 'e')
            ->join('e.groups', 'g')
            ->join('e.subject', 'te')
            ->join('e.classroom', 'c')
            ->where(
                $qb->expr()
                   ->between('e.courseDate', ':startDate', ':endDate')
            )
            ->andWhere('g.id IN (:group) ')
            ->setParameter('group', $groupId)
            ->setParameter('startDate', $startDate->format('Y-m-d'))
            ->setParameter('endDate', $endDate->format('Y-m-d'))
            ->getQuery()
            ->getArrayResult();
    }
}