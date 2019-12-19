<?php

namespace App\Manager\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrmService
{
     /**
     *
     * @var object
     */
    private $container;

    /**
     *
     * @var object
     */
    private $em;

    /**
     *
     * @var object
     */
    private $request;

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return object
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @return object
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @param object $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * AppAssembler constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        $this->request = $container->get('request_stack')->getCurrentRequest();
    }

    /**
     *
     * @param FormInterface $form
     * @param object $entity
     * @param JsonResponse $response
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function add(FormInterface $form, $entity, JsonResponse $response){
        $em = $this->getEm();
        $em->getConnection()->beginTransaction();
        $entity = $form->getData();
        try {
            $em->persist($entity);
            $em->flush();
            $em->getConnection()->commit();
            $this->getRequest()->getSession()->getFlashBag()->add('notice',
                'Enregistrement effectué !');
            $response->setData([
                'status' => 'OK',
                'message' => 'Enregistrement effectué avec succès'
            ]);
        } catch (\Exception $e) {
            // Rollback the failed transaction attempt
            $em->getConnection()->rollback();
            $this->getRequest()->getSession()->getFlashBag()->add('danger',
                'Une erreur est intervenue: '.$e->getMessage());
            $response->setData([
                'status' => 'NOK',
                'message' => 'Une erreur est intervenue !' . $e->getMessage()
            ]);
            return $response;

        }

        return $response;
    }

    /**
     *
     * @param FormInterface $form
     * @param JsonResponse $response
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(FormInterface $form, JsonResponse $response){
        $em = $this->getEm();
        $em->getConnection()->beginTransaction();
        try {
            $em->flush();
            $em->getConnection()->commit();
            $this->getRequest()->getSession()->getFlashBag()->add('notice',
                'Mise à jour effectuée !');
            $response->setData([
                'status' => 'OK',
                'message' => 'Mise à jour effectuée avec succès'
            ]);
        } catch (\Exception $e) {
            // Rollback the failed transaction attempt
            $em->getConnection()->rollback();
            $this->getRequest()->getSession()->getFlashBag()->add('danger',
                'Une erreur est intervenue: '.$e->getMessage());
            $response->setData([
                'status' => 'NOK',
                'message' => 'Une erreur est intervenue: '.$e->getMessage()
            ]);

            return $response;
        }

        return $response;
    }

    /**
     * @param $entity
     * @param JsonResponse $response
     * @return JsonResponse
     */
    public function delete($entity,JsonResponse $response){
        $em = $this->getEm();
        $em->getConnection()->beginTransaction();
        try {
            $em->remove($entity);
            $em->flush();
            $em->getConnection()->commit();
            $this->getRequest()->getSession()->getFlashBag()->add('notice',
                'Suppression effectuée !');
            $response->setData([
                'status' => 'OK',
                'message' => 'Suppression effectuée !'
            ]);
        } catch (\Exception $e) {
            $this->getRequest()->getSession()->getFlashBag()->add('danger',
                'Une erreur est intervenue: '.$e->getMessage());
            // Rollback the failed transaction attempt
            $em->getConnection()->rollback();
            $response->setData(
                [
                    'statut'  => 'NOK',
                    'message' => 'Une erreur est intervenue! : ' . $e->getMessage()
                ]
            );

            return $response;
        }

        return $response;
    }
}