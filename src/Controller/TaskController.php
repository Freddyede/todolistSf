<?php

namespace App\Controller;

use App\Abstract\AbstractSpecificController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[IsGranted('ROLE_ADMIN')]
#[Route('/task', name: 'task.')]
class TaskController extends AbstractSpecificController
{

    #[Route('/', name: 'index')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $this->userServices->findBy(['email' => $authenticationUtils->getLastUsername()])->getTasks(),
            'controller_name' => 'TaskController',
        ]);
    }
}
