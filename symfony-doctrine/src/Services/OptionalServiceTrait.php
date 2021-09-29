<?php

namespace App\Services;
use App\Services\MySecondService;

trait OptionalServiceTrait
{

    private $service;

    /**
     * @required
     */
    public function setSecondService(MySecondService $secondService)
    {
        $this->service = $secondService;
    }

}