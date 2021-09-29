<?php

namespace App\Services;
use Doctrine\ORM\Event\PostFlushEventArgs;

class MyService implements ServiceInterface
{

    // use OptionalServiceTrait;

    // public $logger;
    // public $my;

    // public function __construct(string $param, string $param2, $adminEmail, $globalParam)
    public function __construct()
    {
        // dump($param);
        // dump($param2);
        // dump($adminEmail);
        // dump($globalParam);

        // dump($secondService);

        // dump($service);
        // $this->secService = $service;

        dump ('Hello from constructor!');

    }

    public function postFlush(PostFlushEventArgs $args)
    {
        dump('postFlush hello!');
        dump($args);
    }

    public function clear()
    {   
        dump('Hello from clear!');
    }

    // public function someAction()
    // {
    //     dump($this->service->doSomething2());
    // }

    // public function someAction2()
    // {
    //     // dump($this->logger);
    //     dump($this->my);
    // }

}

?>