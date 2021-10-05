<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Events\VideoCreatedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventController extends AbstractController
{

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }


    /**
     * @Route("/event", name="event")
     */
    public function index(): Response
    {

        $video = new \stdClass();
        $video->title = "funny movie";
        $video->category = "comedy";

        $event = new VideoCreatedEvent($video);

        $this->dispatcher->dispatch($event, 'video.created.event');


        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
}
