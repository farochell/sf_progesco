<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   01/02/2020
 * @time  :   23:11
 */

namespace App\Schooling\Repository;


use App\Schooling\Entity\Registration;
use App\Schooling\Entity\RegistrationGroup;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class RegistrationGroupRepository
 *
 * @package App\Schooling\Repository
 *
 */
class RegistrationGroupRepository extends EntityRepository {
    /**
     * RegistrationGroupRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
    
    /**
     * @param $group
     * @param $level
     *
     * @return mixed
     */
    public function getStudentsNotRegistredInGroup($group, $level ) {
        return $this->getEntityManager()
                    ->createQuery(
                        'SELECT p FROM App\Schooling\Entity\Registration p
                          JOIN p.student s
                          JOIN p.grade gr
                          JOIN gr.level l
                          WHERE p.status =:status AND l.id = :level AND p.id NOT IN (SELECT r.id
                                                               FROM App\Schooling\Entity\RegistrationGroup rg
                                                               JOIN rg.registration r
                                                               JOIN rg.group g
                                                               WITH g.id = :group)
                          ORDER BY s.lastname ASC
                          ')
            ->setParameter('status', Registration::VALIDED)
                    ->setParameter('level', $level)
            ->setParameter('group', $group)
                    ->getResult();
    }
    
    /**
     * @param $groupId
     * @throws \Doctrine\DBAL\DBALException
     */
    public function removeRegistrationGroupByGroupId($groupId)
    {
    
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder();
        $queryBuilder->delete(RegistrationGroup::class, 'u')
            ->where('u.group = :group')
            ->setParameter('group', $groupId);
        $query = $queryBuilder->getQuery();
       
        $query->execute();
       
    }
    
    /**
     * @param $registrationId
     * @throws \Doctrine\DBAL\DBALException
     */
    public function removeRegistrationGroupByRegistrationId($registrationId)
    {
        $conn = $this->getEntityManager()
                     ->getConnection();
        $rawSQL = "DELETE FROM registration_group WHERE registration_id =:registration_id
                   ";
        $stmt = $conn->prepare($rawSQL);
        $stmt->execute(['registration_id' => $registrationId]);
    }
}