<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    /**
     * @Route("/form", name="form")
     */
    public function index(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $videos = $entityManager->getRepository(Video::class)->findAll();
        dump($videos);

        $video = new Video();
        // $video->setTitle('Create a vlog video');
        // $video->setCreatedAt(new \DateTime('tomorrow'));
        $video->setFilename('Filename from form');
        $video->setAuthor(null);
        $video->setDescription('Description from form');
        $video->setDuration('100');
        $video->setFormat('mpeg-2');
        $video->setSize(20000);
    

        $form = $this->createForm(VideoFormType::class, $video);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($video); 
            $entityManager->flush();
            // dump($form->getData());
            return $this->redirectToRoute('form');
        }

        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
            'form' => $form->createView(),
        ]);
    }
}
