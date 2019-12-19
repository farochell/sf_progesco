<?php
/**
 * sf_progesco
 *
 * emile.camara
 * 19/11/2019
 */

namespace App\Pedagogy\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class GradeRepository
 *
 * @package App\Pedagogy\Repository
 *
 */
class GradeRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
    
}