<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   25/11/2019
 * @time  :   11:14
 */

namespace App\Classroom\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class ClassroomRepository
 *
 * @package App\Classroom\Repository
 *
 */
class ClassroomRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
}