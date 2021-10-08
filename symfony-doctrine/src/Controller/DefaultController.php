<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Entity\Author;
use App\Entity\File;
use App\Entity\Video;
use App\Entity\Pdf;
use App\Entity\SecurityUser;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * @Route("/home", name="home")
     */
    public function home(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository(SecurityUser::class)->findAll();
        dump($users);

        // $user = new SecurityUser;
        // $user->setEmail('admin@user.com');
        // $pass = $passwordEncoder->encodePassword($user, '123');
        // $user->setPassword($pass);
        // $user->setRoles(['ROLE_ADMIN']);

        // $video = new Video();
        // $video->setFilename('Filename from form' . rand(1,1000));
        // $video->setAuthor(null);
        // $video->setDescription('Description ');
        // $video->setDuration(100 + rand(1,100));
        // $video->setFormat('mpeg-2');
        // $video->setSize(20000 + rand (100,500));
        // $video->setCreatedAt(new \DateTime());

        // $entityManager->persist($video);
        // $user->addVideo($video);
        // $entityManager->persist($user);        
        // $entityManager->flush();

        // dump($user->getId());
        // dump($video->getId());

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/home/{id}/delete-video", name="delete-video")
     * @Security("user.getId() == video.getSecurityUser().getId()")
     */
    public function deleteVideo(Request $request, UserPasswordEncoderInterface $passwordEncoder, Video $video): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository(SecurityUser::class)->findAll();
        dump($users);
        dump($video);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin(): Response
    {


        // example of in-controller auth:
        // $this->denyAccesUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $this->denyAccesUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        // $this->denyAccesUnlessGranted('ROLE_ADMIN');



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
        $user1->setName('Magda' . random_int(0, 1000));
        $entityManager->persist($user1);

        $user2 = new User();
        $user2->setName('Jacek' . random_int(0, 1000));
        $entityManager->persist($user2);

        $user3 = new User();
        $user3->setName('Laura' . random_int(0, 1000));
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

        if (is_null($id)) {
            $users_array = $repository->findAll();
        } else {
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
                'No user found for id ' . $id
            );
        }

        $user->setName('New Name ' . random_int(0, 1000));
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
                'No user found for id ' . $id
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
        $stmt->execute(['id' => 3]);

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

    /**
     * @Route("/add-videos", name="add-videos")
     */
    public function addVideos()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setName('Magda');

        for ($i = 3; $i < 6; $i++) {
            $video = new Video();
            $video->setTitle('Video title ' . $i);
            $user->addVideo($video);
            $entityManager->persist($video);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        dump('Created a video with the id of ' . $video->getId());
        dump('Created a user with the id of ' . $user->getId());

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/show-videos/{userId}", name="show-videos")
     */
    public function showVideos(int $userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $userId]);

        foreach ($user->getVideos() as $video) {
            dump($video->getTitle());
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/delete-user-with-videos/{userId}", name="delete-user-with-videos")
     */
    public function deleteUserWithVideos(int $userId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $userId]);

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/one-to-one", name="one-to-one")
     */
    public function oneToOne()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setName('Laura');
        $address = new Address();
        $address->setStreet('Wielka');
        $address->setStreet('10');
        $user->setAddress($address);

        $entityManager->persist($user);
        // $entityManager->persist($address); // required if "cascade={persist}" is not set in annotation for User object

        dump($user->getAddress()->getStreet());

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("many-to-many", name="many-to-many")
     */
    public function manyToMany()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user1 = $entityManager->getRepository(User::class)->find(1);
        $user2 = $entityManager->getRepository(User::class)->find(2);
        $user3 = $entityManager->getRepository(User::class)->find(3);
        $user4 = $entityManager->getRepository(User::class)->find(4);

        $user1->addFollowed($user2);
        $user1->addFollowed($user3);
        $user1->addFollowed($user4);

        $entityManager->flush();

        dump($user1->getFollowed()->count());
        dump($user1->getFollowing()->count());
        dump($user4->getFollowing()->count());

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("query-builder", name="query-builder")
     */
    public function queryBuilder()
    {
        $entityManager = $this->getDoctrine()->getManager();
        //$user = $entityManager->getRepository(User::class)->find(1); // LAZY LOADING!!!
        $user = $entityManager->getRepository(User::class)->findWithVideos(2); // EAGER LOADING!!!
        dump($user);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("inheritance-single-table", name="inheritance-single-table")
     */
    public function inheritanceSingleTable()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $items = $entityManager->getRepository(Pdf::class)->findAll();

        dump($items);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("polymorphic-query", name="polymorphic-query")
     */
    public function polymorphicQuery()
    {
        $entityManager = $this->getDoctrine()->getManager();

        // $items = $entityManager->getRepository(File::class)->findAll();
        // dump($items);

        $author = $entityManager->getRepository(Author::class)->findByIdWithPdf(2);
        dump($author);
        foreach ($author->getFiles() as $file) {
            // if($file instanceof Pdf)
            // {
            dump($file->getFilename());
            // }
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
