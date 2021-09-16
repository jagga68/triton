<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\GiftsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

   
    /**
     * @Route("/", name="default")
     */
    public function index(GiftsService $gifts)
    {
        // $users = ['Adam', 'Jacek', 'Piotr', 'Robert'];

        // $user1 = new User();
        // $user1->setName('Adam');
        // $user2 = new User();
        // $user2->setName('Robert');
        // $user3 = new User();
        // $user3->setName('Piotr');
        // $user4 = new User();
        // $user4->setName('Barbara');

        // $entityManager = $this->getDoctrine()->getManager();
        // $entityManager->persist($user1);
        // $entityManager->persist($user2);
        // $entityManager->persist($user3);
        // $entityManager->persist($user4);

        // exit($entityManager->flush());

        
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $this->addFlash('notice', 'Your changes have been saved');
        $this->addFlash('warning', 'Your changes have warnings');
        
        
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => $users,
            'random_gift' => $gifts->gifts,
        ]);

    }

    /**
     * @Route("/blog/{page?}", name="blog_list", requirements={"page"="\d+"})
     */

     public function index2()
     {
         return new Response('Optional parameters in url and requirements for parameters');
     }

    /**
     * @Route("/articles/{_locale}/{year}/{slug}/{category}",
     * name="articles_list",
     * defaults={"category" : "computers"},
     * requirements={
     *      "_locale" : "en|fr",
     *      "year" : "\d+",
     *      "category" : "computers|rtv"
     * }
     * 
     * )
     */
    public function index3()
    {
        return new Response('An advanced routing example');
    }

    /**
     * @Route({
     *      "nl" : "/over-ons",
     *      "en" : "/about-us",
     *      "pl" : "/o-nas"
     *  }, name="about_us"
     * )
     */
    public function index4()
    {
        return new Response('Translated routes');
    }


}
