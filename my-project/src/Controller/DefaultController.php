<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\GiftsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends AbstractController
{

    public function __construct($logger)
    {
        // use $logger service
    }

    /**
     * @Route("/home", name="default", name="home")
     */
    public function index()
    {
        //exit('Index here');
        return $this->render(
            'default/index.html.twig', [
                'controller_name' => 'DefaultController'
            ]
        );
    }

    public function mostPopularPosts($number = 3)
    {
        // database call:
        $posts = ['post 1', 'post 2', 'post 3', 'post 4'];
        return $this->render(
            'default/most_popular_posts.html.twig', [
                'posts' => $posts
            ]
        );
    }
   
    /**
     * @Route("/", name="default_demo")
     */
    public function index_demo(GiftsService $gifts, 
            Request $request,
            SessionInterface $session    
        )
    {
        // --------- basics & Doctrine -----------
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

        // ------ Cookies --------
        // $cookie = new Cookie('jag_cookie', 'jag_value', time() + (2 * 365 * 24 * 60 * 60));
        // $res = new Response();
        // $res->headers->setCookie($cookie);
        // $res->send();
        
        // $res = new Response();
        // $res->headers->clearCookie('jag_cookie');
        // $res->send();
        
        // exit($request->cookies->get('jag_cookie'));

        // ------ Session --------
        // $session->set('name', 'session value'); // removes only 
        // // $session->remove('name');
        // $session->clear(); // removes all session data
        // if($session->has('name'))
        // {
        //     exit($session->get('name'));
        // }
        
        // exit($request->query->get('page', 'default_value'));
        // exit($request->server->get('HTTP_HOST'));
        // $request->isXmlHttpRequest(); // is it an Ajax request?
        // $request->request->get('page');
        // $request->files->get('foo');
        
        $this->addFlash('notice', 'Your changes have been saved');
        $this->addFlash('warning', 'Your changes have warnings');
        
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        if(!$users)
        {
            throw $this->createNotFoundException('The users dont exist');
        }
        
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => $users,
            'random_gift' => $gifts->gifts,
        ]);

    }

    /**
     * @Route("/generate-url/{param?}", name="generate_url")
     */
    public function generate_url()
    {
        exit($this->generateUrl(
                'generate_url',
                array('param' => 10),
                UrlGeneratorInterface::ABSOLUTE_URL
            ));

    }

    /**
     * @Route("/download")
     */
    public function download()
    {
        $path = $this->getParameter('download_directory');

        return $this->file($path.'file.pdf');
    }

    /**
     * @Route("/redirect-test")
     */
    public function redirectTest()
    {
        return $this->redirectToRoute('route_to_redirect', array('param' => 10));
    }

    /**
     * @Route("/url-to-redirect/{param?}", name="route_to_redirect")
     */
    public function methodToRedirect()
    {
        exit('Test redirection');
    }

    /**
     * @Route("/forwarding-to-controller")
     */
    public function forwardingToController()
    {
        $response = $this->forward(
            'App\Controller\DefaultController::methodToForwardTo',
            array('param' => 5)
        );

        return $response;
    }

    /**
     * @Route("/url-to-forwar-to/{param?}", name="rout_to_forward_to")
     */
    public function methodToForwardTo($param)
    {
        exit('Test controller forwarding - ' . $param);
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
