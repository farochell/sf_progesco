<?php


namespace App\Configuration\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class GenderRepository
 * @package App\Configuration\Repository
 * emile.camara
 * 16/11/2019
 */
class GenderRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
    
}