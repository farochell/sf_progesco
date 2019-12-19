<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   18/12/2019
 * @time  :   23:49
 */

namespace App\Security\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class UserRepository
 *
 * @package App\Security\Repository
 *
 */
class UserRepository extends EntityRepository
{
    /**
     * UserRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
}