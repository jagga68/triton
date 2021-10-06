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
        // $videos = $entityManager->getRepository(Video::class)->findAll();

        $video = new Video();
        $video->setFilename('Filename from form');
        $video->setAuthor(null);
        $video->setDescription('Description from form');
        $video->setDuration('100');
        $video->setFormat('mpeg-2');
        $video->setSize(20000);
    
        // $video = $entityManager->getRepository(Video::class)->find(12);
        // dump($video);

        $form = $this->createForm(VideoFormType::class, $video);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $file = $form->get('file')->getData();
            // $fileName = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
            $fileName = sha1(random_bytes(14)) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('videos_directory'),
                $fileName
            );
            $video->setFile($fileName);
            $entityManager->persist($video); 
            $entityManager->flush();
            return $this->redirectToRoute('form');
        }

        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
            'form' => $form->createView(),
        ]);
    }
}
