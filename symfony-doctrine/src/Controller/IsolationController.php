<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\SecurityUser;
use App\Entity\Video;
use App\Entity\Address;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Services\ServiceInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use App\Events\VideoCreatedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Form\VideoFormType;
use App\Form\RegisterUserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class IsolationController extends AbstractController
{
    
    /**
     * @Route("/isolation", name="isolation")
     */
    public function index(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $videos = $entityManager->getRepository(Video::class)->findAll();
        dump($videos);

        return $this->render('isolation/index.html.twig', [
            'controller_name' => 'IsolationController',
        ]);
    }  
    
}
