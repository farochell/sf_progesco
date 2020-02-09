<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/02/2020
 * @time  :   11:11
 */

namespace App\Scoring\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class TypeOfRatingRepository
 *
 * @package App\Scoring\Repository
 *
 */
class TypeOfRatingRepository extends EntityRepository {
    /**
     * TypeOfRatingRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
}