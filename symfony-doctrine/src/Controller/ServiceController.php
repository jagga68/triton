<?php

namespace App\Controller;

use App\Services\ServiceInterface;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     */
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    /**
     * @Route("/service-param", name="service-param")
     */
    public function serviceParam(): Response
    {

        // $myService->someAction();
        // $myService->someAction2();

        // dump($myService->secService->someMethod());
        
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);

    }

    /**
     * @Route("/service-tags", name="service-tags")
     */
    public function serviceTags()
    {

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find(1);
        $user->setName('Rob');
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
  
    /**
     * @Route("/service-interface", name="service-interface")
     */
    public function serviceInterface(ServiceInterface $service)
    {

        $entityManager = $this->getDoctrine()->getManager();
       
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
  

}
