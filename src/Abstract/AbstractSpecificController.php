<?php

namespace App\Abstract;

use App\Services\UserServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractSpecificController extends AbstractController
{


    protected UserServices $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }
}