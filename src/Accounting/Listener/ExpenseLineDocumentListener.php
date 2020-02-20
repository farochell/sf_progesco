<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   14/02/2020
 */

namespace App\Accounting\Listener;


use App\Accounting\Entity\ExpenseLineDocument;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ExpenseLineDocumentListener
 *
 * @package App\Accounting\Listener
 *
 */
class ExpenseLineDocumentListener {
    
    /**
     * @var ContainerInterface
     */
    private $container;
    
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /**
     * @param LifecycleEventArgs $args
     *
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $args) {
        $object        = $args->getObject();
        if (!$object instanceof ExpenseLineDocument) {
            return;
        }
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $object->setUserCreation($user);
        $object->setCreated(new \DateTime('now'));
        $object->setUpdated(new \DateTime('now'));
    }
}