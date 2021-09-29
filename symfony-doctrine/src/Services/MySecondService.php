<?php

namespace App\Services;

class MySecondService implements ServiceInterface
{
    public function __construct()
    {
        dump('Hello from my second service constructor');
        // $this->doSomething();
    }

    // public function doSomething()
    // {
    //     # code...
    // }

    // public function doSomething2()
    // {
    //     return 'Wow from doSomething2';
    // }

    public function someMethod()
    {
        return (' hello from my second service');
    }
}