<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   27/11/2019
 * @time  :   21:29
 */

namespace App\Pedagogy\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class SemesterRepository
 *
 * @package App\Pedagogy\Repository
 *
 */
class SemesterRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
    
}