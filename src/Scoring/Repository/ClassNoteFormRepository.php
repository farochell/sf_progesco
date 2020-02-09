<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   08/02/2020
 * @time  :   12:32
 */

namespace App\Scoring\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class ClassNoteFormRepository
 *
 * @package App\Scoring\Repository
 *
 */
class ClassNoteFormRepository extends EntityRepository {
    /**
     * ClassNoteFormRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
}