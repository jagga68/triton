<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/add-users", name="add-users")
     */
    public function addUsers(): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $user1 = new User();
        $user1->setName('Magda' . random_int(0,1000));
        $entityManager->persist($user1);
        
        $user2 = new User();
        $user2->setName('Jacek' . random_int(0,1000));
        $entityManager->persist($user2);

        $user3 = new User();
        $user3->setName('Laura' . random_int(0,1000));
        $entityManager->persist($user3);

        $entityManager->flush();

        $repository = $this->getDoctrine()->getRepository(User::class);
        $users_array = $repository->findAll();

        return $this->render('default/show-users.html.twig', [
            'users' => $users_array,
        ]);
    }

    /**
     * @Route("/show-users/{id?}", name="show-users")
     */
    public function showUsers(?int $id): Response
    {

        $repository = $this->getDoctrine()->getRepository(User::class);
        
        if(is_null($id))
        {
            $users_array = $repository->findAll();
        }
        else
        {
            $users_array = $repository->findBy(['id' => $id]);
        }

        if (!$users_array) {
            throw $this->createNotFoundException(
                'No user(s) found.'
            );
        }

        return $this->render('default/show-users.html.twig', [
            'users' => $users_array,
        ]);
        
    }
    
    /**
     * @Route("/update-user/{id}", name="update-user")
     */
    public function updateUser(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $user->setName('New Name ' . random_int(0,1000));
        $entityManager->flush();

        return $this->redirectToRoute('show-users');
    }
    
    /**
     * @Route("/delete-user/{id}", name="delete-user")
     */
    public function deleteUser(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('show-users');
    }

    /**
     * @Route("/raw-query", name="raw-query")
     */
    public function rawQuery(\Doctrine\DBAL\Driver\Connection $connection): Response
    {

        $sql = 'SELECT * 
                FROM 
                    user u 
                WHERE 
                    u.id > 3
                ';

        $stmt = $connection->prepare($sql);
        $stmt->execute(['id' => 3 ]);

        $users_array = $stmt->fetchAll();

        return $this->render('default/show-users.html.twig', [
            'users' => $users_array,
        ]);

    }

    /**
     * @Route("/user/{id}", name="user")
     */
    public function paramConverter(User $user)
    {
        // below is not needed when using sensio/framework-extra-bundle
        // $entityManager = $this->getDoctrine()->getManager();

        //dump($user);

        return $this->redirectToRoute('show-users', ['id' => $user->getId()]);

    }

    /**
     * @Route("/callback", name="callback")
     */
    public function callback()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setName('Jacol 500');
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('OK!');

    }

}
