<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   24/12/2019
 * @time  :   15:04
 */

namespace App\Schooling\Repository;


use App\Pedagogy\Entity\Grade;
use App\Schooling\Entity\Registration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class RegistrationRepository
 *
 * @package App\Registration\Repository
 *
 */
class RegistrationRepository extends EntityRepository {
    /**
     * RegistrationRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
    
    /**
     * @param Grade $grade
     *
     * @return mixed
     */
    public function findStudentsNotRegistredInGroupByGrade(Grade $grade, $groupId) {
        return $this->getEntityManager()
                    ->createQuery(
                        'SELECT p FROM App\Schooling\Entity\Registration p
                          JOIN p.student s
                          JOIN p.grade gr
                          JOIN gr.level l
                          WHERE p.status =:status AND gr.id = :grade AND l.id = :level AND p.id NOT IN (SELECT r.id
                                                               FROM App\Schooling\Entity\RegistrationGroup rg
                                                               JOIN rg.group grp
                                                               JOIN rg.registration r
                                                               WITH grp.id = :group)
                          ORDER BY s.lastname ASC
                          '
                    )
                    ->setParameter('status', Registration::VALIDED)
                    ->setParameter('level', $grade->getLevel())
                    ->setParameter('grade', $grade->getId())
                    ->setParameter('group', $groupId)
                    ->getResult();
    }
}