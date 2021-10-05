<?php

namespace App\Listeners;

class VideoCreatedListener
{

    public function onVideoCreatedEvent($event)
    {
        dump($event->video->title);
    }

}

?>