<?php

namespace App\Services;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class KernelResponseListener
{
    public function onKernelResponse(ResponseEvent $event)
    {
        $response = new \Symfony\Component\HttpFoundation\Response('response');
        $event->setResponse($response);
    }
}

?>