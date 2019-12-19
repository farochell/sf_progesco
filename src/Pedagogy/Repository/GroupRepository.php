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
 * Class LevelRepository
 *
 * @package App\Pedagogy\Repository
 *
 */
class GroupRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
    
}