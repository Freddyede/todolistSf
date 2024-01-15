<?php

namespace App\Controller;

use App\Abstract\AbstractSpecificController;
use App\Entity\Tasks;
use App\Form\TaskFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/{id}', name: 'read')]
    public function read(EntityManagerInterface $em, $id): Response
    {
        return $this->render('task/read.html.twig', [
            'task' => $em->getRepository(Tasks::class)->find($id),
            'controller_name' => 'TaskController',
        ]);
    }
    #[Route('/create/{id}', name: 'createOrUpdate')]
    public function save(Request $request, AuthenticationUtils $authenticationUtils, EntityManagerInterface $em, int $id):  RedirectResponse|Response
    {
        $user = $this->userServices->findBy(['email' => $authenticationUtils->getLastUsername()]);
        $task = ($id > 0) ? $em->getRepository(Tasks::class)->find($id) : new Tasks();
        $formTask = $this->createForm(TaskFormType::class, $task);
        $formTask->handleRequest($request);
        if($formTask->isSubmitted() && $formTask->isValid())
        {
            $taskData = $formTask->getData();
            $task->setLabel($taskData->getLabel())
            ->setDescription($taskData->getDescription())
            ->addUser($user);
            $user->addTask($task);
            $em->persist($task);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('task.index');
        }
        return $this->render('task/create.html.twig', [
            'form' => $formTask->createView()
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $em, $id): RedirectResponse
    {
        $em->remove($em->getRepository(Tasks::class)->find($id));
        $em->flush();
        return $this->redirectToRoute('task.index');
    }
}
