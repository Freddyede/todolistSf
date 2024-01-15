<?php

namespace App\Controller;

use App\Services\UserServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class TaskController extends AbstractController
{

    private UserServices $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/task', name: 'task.index')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $this->userServices->findBy(['email' => $authenticationUtils->getLastUsername()])->getTasks(),
            'controller_name' => 'TaskController',
        ]);
    }
}
