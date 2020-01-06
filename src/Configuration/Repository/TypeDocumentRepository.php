<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   30/12/2019
 * @time  :   12:20
 */

namespace App\Configuration\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class TypeDocumentRepository
 *
 * @package App\Configuration\Repository
 *
 */
class TypeDocumentRepository extends EntityRepository
{
    /**
     * TypeDocumentRepository constructor.
     *
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata  $class
     */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) { parent::__construct($em, $class); }
    
}