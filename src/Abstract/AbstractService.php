<?php

namespace App\Abstract;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class AbstractService
{

    protected const USER_ENTITY_TARGET = User::class;

    protected EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->em = $doctrine;
    }
}