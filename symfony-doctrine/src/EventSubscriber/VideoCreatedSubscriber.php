<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpFoundation\Response;

class VideoCreatedSubscriber implements EventSubscriberInterface
{
    public function onVideoCreatedEvent($event)
    {
        dump($event->video->title);
    }

    public function onKernelResponse1(ResponseEvent $event)
    {
        $response = new Response('new response 1');
        // $event->setResponse($response);
        dump('1');
    }

    public function onKernelResponse2(ResponseEvent $event)
    {
        $response = new Response('new response 2');
        // $event->setResponse($response);
        dump('2');
    }

    public static function getSubscribedEvents()
    {
        return [
            // below is commented out as it was needed only in Listeners/Subscribers lecture
            // 'video.created.event' => 'onVideoCreatedEvent',
            // KernelEvents::RESPONSE => [
            //     ['onKernelResponse1', 1],   // SECOND ELEMENT IS PRIORITY NUMBER
            //     ['onKernelResponse2', 2],
            // ]
        ];
    }
}
